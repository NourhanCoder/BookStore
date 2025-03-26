<?php

namespace App\Interfaces;


interface CartInterface
{
    public function addItem($id, $name, $price, $image, $quantity = 1);
    public function updateQty($id, $qty);
    public function removeItem($id);
    public function getItems();
    public function clearCart();
}