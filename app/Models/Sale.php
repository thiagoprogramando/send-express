<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

    use HasFactory;

    protected $table = 'sale';

    protected $fillable = [
        'id_seller',
        'id_product',
        'id_client',
        
        'method',
        'installments',

        'status',
        'delivery',

        'token',
        'url',
        'key_unique',
    ];

    public function seller() {
        return $this->belongsTo(User::class, 'id_seller');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function client() {
        return $this->belongsTo(User::class, 'id_client');
    }

    public function statusLabel() {

        switch ($this->status) {
            case 'pendent':
                return 'Pendente';
                break;
            case 'approved':
                return 'Aprovado';
                break;
            case 'cancel':
                return 'Cancelado';
                break; 
            case 'approved & send':
                return 'Aprovado e Enviado';
                break; 
            default:
                return '---';
                break;         
            return $this->method;
        }
    }

    public function statusBadge() {

        switch ($this->status) {
            case 'pendent':
                return 'badge-warning';
                break;
            case 'approved':
                return 'badge-success';
                break;
            case 'cancel':
                return 'badge-danger';
                break; 
            case 'approved & send':
                return 'badge-success';
                break; 
            default:
                return 'badge-dark';
                break;        
            return $this->method;
        }
    }

    public function methodLabel() {

        switch ($this->method) {
            case 'CREDIT_CARD':
                return 'Cartão de Crédito/Débito';
                break;
            case 'BOLETO':
                return 'Boleto Bancário';
                break;
            case 'PIX':
                return 'PIX';
                break; 
            default:
                return '---';
                break;         
            return $this->method;
        }
    }
}
