<?php

namespace App\Filament\Resources\Movimentos\Pages;

use App\Filament\Resources\Movimentos\MovimentoResource;
use Filament\Resources\Pages\CreateRecord;
use APP\Models\Produto;
use APP\Models\Movimento;
use Filament\Notifications\Notification;

class CreateMovimento extends CreateRecord
{
    protected static string $resource = MovimentoResource::class;
    /**
     * O que a beforeCreate faz?
     * .....
     * * O que a beforeCreate faz?
     * 
     * @param $data recebe os dados do produto
     *@param $produto recebe uma lista com os dados dos produtos pelo id
     * 
     */
    protected function beforeCreate(): void
    {
//recebe a lista de produtos
    $data = $this->data;

//.selecionando. o produto/qtd.e.tipo pelo id recebido na lista
    $produto = Produto :: find($data['produto_id']);
    $quantidade = $data['quantidade'];
    $tipo = $data['tipo'];

//.Verificar se é uma saida e se o estoque é suficiente
if ($tipo === 's' && $quantidade > $produto->estoque) {

//.Notificar.o usuário.sobre o estoque insuficiente
    Notification :: make()
        ->danger()
        ->title('Estoque Insuficiente!')
        ->body("O estoque de '{$produto->nome}'e de apenas .{$produto->estoque} unidade, mas voce tentou retirar {$quantidade}.")
        ->send();

        $this->halt();//.Impede a criacão.do movimento
        }
    }
    // Hook - Remover ou aumenta o estoque
    protected function afterCreate(): void
    {
        $movimento = $this->getRecord ();
        $produto = $movimento->produto;

        if ($movimento->tipo === 'e') {

            $produto->increment('estoque', $movimento->quantidade);
        } else{
            $produto->decrement('estoque', $movimento->quantidade);
        }
    }
}

