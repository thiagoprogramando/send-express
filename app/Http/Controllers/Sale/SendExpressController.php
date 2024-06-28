<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use App\Mail\Product as MailProduct;
use App\Models\Images;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SendExpressController extends Controller {
    
    public function checkoutExpress($product, $seller) {

        $product = Product::find($product);
        if($product && $product->status == 1) {

            if(!Auth::check()) {
                $product->views += 1;
                $product->save();
            }
            
            $images = Images::where('id_product', $product->id)->get();
            return view('checkout.checkout', [
                'product' => $product,
                'seller'  => $seller,
                'images'  => $images
            ]);
        }

        return view('checkout.default', ['product' => $product]);
    }

    public function thankYou() {

        return view('checkout.thank-you');
    }

    public function sendSale(Request $request) {

        $client = $this->createClient($request->name, $request->email, $request->cpfcnpj, $request->phone, $request->saller);
        if($client === false || $client === 0) {
            return redirect()->back()->with('error', 'Verifique seus dados e tente novamente!');
        }

        $product = Product::find($request->id_product);
        if(!$product) {
            return redirect()->back()->with('error', 'O produto não está mais disponível!');
        }

        switch($request->method) {
            case 'PIX':
                $payment = $this->createPix($client->customer, $request->value, $request->installments, $product->name, $product->url_redirect);
                break;
            case 'BOLETO':
                $payment = $this->createBoleto($client->customer, $request->value, $request->installments, $product->name, $product->url_redirect);
                break;
            case 'CREDIT_CARD':
                $payment = $this->createCredit($client->customer, $request->value, $request->installments, $product->name, $product->url_redirect);
                break;
            default:
                return redirect()->back()->with('error', 'Nenhuma forma de pagamento informada!');
                break;
        }

        if(!$payment) {
            return redirect()->back()->with('error', 'Instabilidade momentânea, por favor, tente novamente mais tarde!');
        }
        
        $sale               = new Sale();
        $sale->id_seller    = $request->id_seller;
        $sale->id_product   = $product->id;
        $sale->id_client    = $client->id;
        $sale->method       = $request->method;
        $sale->installments = $request->installments;
        $sale->token        = $payment['id'];
        $sale->url          = $payment['invoiceUrl'];
        if($sale->save()) {
            return redirect($payment['invoiceUrl']);
        }

        return redirect()->back()->with('error', 'Verifique seus dados e tente novamente!');
    }

    private function createClient($name,  $email, $cpfcnpj, $phone, $indicator) {

        $user = User::where('email', $email)->orWhere('cpfcnpj', $cpfcnpj)->first();
        if($user && !empty($user->customer)) {
            return $user;
        }
        
        $client = new Client();

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => env('API_TOKEN_ASSAS'),
            ],
            'json' => [
                'name'          => $name,
                'cpfCnpj'       => $cpfcnpj,
                'mobilePhone'   => $phone,
                'email'         => $email,
            ],
            'verify' => false
        ];

        $response = $client->post(env('API_URL_ASSAS') . 'v3/customers', $options);
        $body = (string) $response->getBody();
        
        if ($response->getStatusCode() === 200) {
            $data = json_decode($body, true);

            if($user && empty($user->customer)) {
                $client = User::where('email', $email)->orWhere('cpfcnpj', $cpfcnpj)->first();
            } else {
                $client = new User();
            }

            $client->name           = $name;
            $client->cpfcnpj        = $cpfcnpj;
            $client->email          = $email;
            $client->password       = bcrypt($cpfcnpj);
            $client->role           = 'client';
            $client->customer       = $data['id'];
            $client->id_indicator   = $indicator;

            if($client->save()) {
                return $client;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function createPix($customer, $value, $installments, $description, $url = null) {

        $client = new Client();

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => env('API_TOKEN_ASSAS'),
            ],
            'json' => [
                'customer'          => $customer,
                'billingType'       => 'PIX',
                'value'             => number_format($value, 2, '.', ''),
                'dueDate'           => now()->addDay(),
                'description'       => $description,
                'installmentCount'  => $installments > 1 ? $installments : 1,
                'installmentValue'  => $installments > 1 ? number_format(($value / intval($installments)), 2, '.', '') : $value,
                'callback'          => [
                    'successUrl'   => $url ?: env('THANK_YOU'),
                    'autoRedirect' => true
                ]
            ],
            'verify' => false
        ];

        // if($value > 10) {
        //     $options['json']['split'][] = [
        //         'walletId'          => env('APP_WALLET'),
        //         'totalFixedValue'   => 5
        //     ];
        // }

        $response = $client->post(env('API_URL_ASSAS') . 'v3/payments', $options);
        $body = (string) $response->getBody();

        if ($response->getStatusCode() === 200) {
            $data = json_decode($body, true);
            return $dados['json'] = [
                'id'            => $data['id'],
                'invoiceUrl'    => $data['invoiceUrl'],
            ];
        } else {
            return false;
        }
    }

    private function createBoleto($customer, $value, $installments, $description, $url = null) {

        $client = new Client();

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => env('API_TOKEN_ASSAS'),
            ],
            'json' => [
                'customer'          => $customer,
                'billingType'       => 'BOLETO',
                'value'             => number_format($value, 2, '.', ''),
                'dueDate'           => now()->addDay(),
                'description'       => $description,
                'installmentCount'  => $installments > 1 ? $installments : 1,
                'installmentValue'  => $installments > 1 ? number_format(($value / intval($installments)), 2, '.', '') : $value,
                'callback'          => [
                    'successUrl'   => $url ?: env('THANK_YOU'),
                    'autoRedirect' => true
                ]
            ],
            'verify' => false
        ];

        // if($value > 10) {
        //     $options['json']['split'][] = [
        //         'walletId'          => env('APP_WALLET'),
        //         'totalFixedValue'   => 5
        //     ];
        // }

        $response = $client->post(env('API_URL_ASSAS') . 'v3/payments', $options);
        $body = (string) $response->getBody();

        if ($response->getStatusCode() === 200) {
            $data = json_decode($body, true);
            return $dados['json'] = [
                'id'            => $data['id'],
                'invoiceUrl'    => $data['invoiceUrl'],
            ];
        } else {
            return false;
        }
    }

    private function createCredit($customer, $value, $installments, $description, $url = null) {

        $client = new Client();

        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'access_token' => env('API_TOKEN_ASSAS'),
            ],
            'json' => [
                'customer'          => $customer,
                'billingType'       => 'CREDIT_CARD',
                'value'             => number_format($value, 2, '.', ''),
                'dueDate'           => now()->addDay(),
                'description'       => $description,
                'installmentCount'  => $installments > 1 ? $installments : 1,
                'installmentValue'  => $installments > 1 ? number_format(($value / intval($installments)), 2, '.', '') : $value,
                'callback'          => [
                    'successUrl'   => $url ?: env('THANK_YOU'),
                    'autoRedirect' => true
                ]
            ],
            'verify' => false
        ];

        // if($value > 10) {
        //     $options['json']['split'][] = [
        //         'walletId'          => env('APP_WALLET'),
        //         'totalFixedValue'   => 5
        //     ];
        // }

        $response = $client->post(env('API_URL_ASSAS') . 'v3/payments', $options);
        $body = (string) $response->getBody();

        if ($response->getStatusCode() === 200) {
            $data = json_decode($body, true);
            return $dados['json'] = [
                'id'            => $data['id'],
                'invoiceUrl'    => $data['invoiceUrl'],
            ];
        } else {
            return false;
        }
    }

    public function webhook(Request $request) {

        $jsonData = $request->json()->all();
        if ($jsonData['event'] === 'PAYMENT_CONFIRMED' || $jsonData['event'] === 'PAYMENT_RECEIVED') {
            
            $token = $jsonData['payment']['id'];
            $sale = Sale::where('token', $token)->first();
            if($sale) {

                $sale->status = 'approved';
                $send = $this->sendProduct($sale->id);
                if($send) {
                    $sale->delivery = 1;
                    $sale->save();

                    return response()->json(['status' => 'success', 'message' => 'produto enviado ao cliente!']);
                }

                return response()->json(['status' => 'success', 'message' => 'Produto não enviado ao cliente!']);
            }

            return response()->json(['status' => 'success', 'message' => 'Venda não encontrada!']);
        }

        return response()->json(['status' => 'success', 'message' => 'Webhook não utilizado!']);
    }

    private function sendProduct($sale) {

        $sale = Sale::find($sale);
        if(!$sale) {
            return false;
        }

        $product = Product::find($sale->id_product);
        if(!$product) {
            return false;
        }

        $client = User::find($sale->id_client);
        if(!$client) {
            return false;
        }

        $user = User::find($product->id_user);
        if(!$user) {
            return false;
        }

        try {
            Mail::to($client->email, $client->name)->send(new MailProduct([
                'fromName'      => 'Suporte IFUTURE',
                'fromEmail'     => 'suporte@ifuture.cloud',
                'fromUserName'  => $user->name,
                'fromUserEmail' => $user->email,
                'toName'        => $client->name,
                'product'       => $product->file,
                'subject'       => $product->name,
            ]));
    
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
