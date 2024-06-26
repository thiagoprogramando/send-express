<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;

use App\Models\Images;
use App\Models\Product;
use App\Models\Sale;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller {
    
    public function listProducts() {

        $products = Product::where('id_user', Auth::user()->id)->get();
        return view('app.Product.list-products', ['products' => $products]);
    }

    public function createProduct($id = null) {

        if($id) {
            $product = Product::find($id);
            if($product) {
                $images = Images::where('id_product', $product->id)->get();
                return view('app.Product.create-product', ['product' => $product, 'images' => $images]);
            } else {
                return redirect()->back()->with('error', 'Não foram identificado dados do Produto, tente novamente mais tarde!');
            }
        }

        $product = new Product();
        $product->id_user = Auth::user()->id;
        
        if($product->save()) {
            
            return redirect()->route('create-product', ['id' => $product->id]);
        }

        return redirect()->back()->with('error', 'Não foram identificado dados do Produto, tente novamente mais tarde!');
    }

    public function updateProduct(Request $request) {

        $product = Product::find($request->id);
        if($product) {

            $product->name                   = $request->name;
            $product->value                  = $request->value;
            $product->status                 = $request->status;
            $product->description            = $request->description;
            $product->url_redirect           = $request->url;
            $product->credit_opt             = $request->credit_opt;
            $product->credit_installments    = $request->credit_installments;
            $product->boleto_opt             = $request->boleto_opt;
            $product->boleto_installments    = $request->boleto_installments;
            $product->pix_opt                = $request->pix_opt;
            $product->pix_installments       = $request->pix_installments;

            if ($request->hasFile('file')) {

                $file = $request->file('file');

                $maxSize = 25 * 1024 * 1024;
                if($file->getSize() > $maxSize) {
                    return redirect()->back()->with('error', 'O arquivo é muito grande, tamanho máx: 25mb!');
                }

                $path = $file->store('files-products', 'public');
                $product->file = $path;
            }

            if ($product->save()) {

                return redirect()->back()->with('success', 'Dados atualizados!');
            }

            return redirect()->back()->with('error', 'Não foi possível atualizar os dados, tente novamente mais tarde!');
        }

        return redirect()->back()->with('error', 'Não foram identificado dados do Produto, tente novamente mais tarde!');
    }

    public function deleteProduct(Request $request) {

        $product = Product::find($request->id);
        if ($product) {
            DB::beginTransaction();
            try {
                
                $sales = Sale::where('id_product', $product->id)->get();
                foreach ($sales as $sale) {
                    $sale->delete();
                }
    
                $product->delete();
    
                DB::commit();
                return redirect()->back()->with('success', 'Produto deletado com sucesso!');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Não foi possível excluir o produto e suas vendas associadas. Erro: ' . $e->getMessage());
            }
        }
    
        return redirect()->back()->with('error', 'Produto não encontrado. Tente novamente mais tarde!');
    }

    public function sendImageProduct(Request $request) {

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('images-products', 'public');
            
            $image = new Images();
            $image->id_product = $request->id_product;
            $image->file = $path;

            if($image->save()) {
                return back()->with('success', 'Imagem enviada com sucesso!');
            }

            return back()->with('error', 'Ops! Não foi possível finalizar o upload.');
        }

        return back()->with('error', 'Nenhuma imagem foi selecionada.');
    }

    public function deleteImageProduct($id) {
        
        $image = Images::find($id);
        if ($image && $image->delete()) {
            
            unlink($image->file);
            return back()->with('success', 'Imagem excluída com sucesso!');
        } else {
            return back()->with('error', 'Imagem não encontrada!');
        }
    }
}
