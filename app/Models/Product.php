<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {

    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id_user',
        
        'name',
        'description',
        'file',

        'value',

        'credit_opt',
        'credit_installments',
        'boleto_opt',
        'boleto_installments',
        'pix_opt',
        'pix_installments',

        'url_redirect',
        'status',
        'views',
    ];

    public function statusLabel() {

        switch ($this->status) {
            case 0:
                return 'Pendente';
                break;
            case 1:
                return 'Ativo';
                break;
            case 2:
                return 'Bloqueado';
                break; 
            case 3:
                return 'Sem estoque/indiponível';
                break; 
            default:
                return '---';
                break;         
            return $this->method;
        }
    }

    public function statusBadge() {

        switch ($this->status) {
            case 0:
                return 'badge-warning';
                break;
            case 1:
                return 'badge-success';
                break;
            case 2:
                return 'badge-danger';
                break; 
            case 3:
                return 'badge-prmary';
                break; 
            default:
                return 'badge-dark';
                break;        
            return $this->method;
        }
    }

}
