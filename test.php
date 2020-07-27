<?php

interface iCart
{
    public function calcVat();

    public function notify();

    public function makeOrder($discount = 1.0);

    public function calcPrice($comission = 1.18);
}

class Cart implements iCart
{
    public $items;
    public $order;

    public function calcPrice($comission)
    {
        $price = 0;
        foreach ($this->items as $item) {
            $price += $item->getPrice() * $comission;
        }
        return $price;
    }

    public function calcVat()
    {
        return $this->calcPrice(0.18);
    }

    public function notify()
    {
        $this->sendMail();
    }

    public function sendMail()
    {
        $m = new SimpleMailer('cartuser', 'j049lj-01');
        $p = $this->calcPrice(1.18);
        $ms = '<p> <b>' . $this->order->id() . '</b> ' . $p . ' .</p>';

        $m->sendToManagers($ms);
    }

    public function makeOrder($discount)
    {
        $p = $this->calcPrice(1.18 * $discount);
        $this->order = new Order($this->items, $p);
        $this->sendMail();
    }
}