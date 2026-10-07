<?php

namespace App\Services;

use Illuminate\Session\SessionManager;

class CartService
{
    public const SESSION_KEY = 'cart';

    public function __construct(private SessionManager $session)
    {
        if(!$this->session->has(self::SESSION_KEY)) $this->session->put(self::SESSION_KEY, []);
    }

    public function all()
    {
        return $this->session->get(self::SESSION_KEY);
    }

    public function count()
    {
        return count($this->all());
    }

    public function has(string $item, string $column = 'id')
    {
        $itemsList = array_column($this->all(), $column);

        return in_array($item, $itemsList);
    }

    public function add(array $item)
    {
        if($this->session->has(self::SESSION_KEY)) {

            if($this->has($item['slug'], 'slug')) {
                $items = $this->increaseExistentProduct($this->all(), $item);

                $this->session->put(self::SESSION_KEY, $items);

                return;
            }

            $this->session->push(self::SESSION_KEY, $item);

        } else {
            $this->session->put(self::SESSION_KEY, [$item]);
        }
    }

    public function remove(string $item)
    {
        $cart = $this->all();

        $this->session->put(self::SESSION_KEY, array_filter($cart, function($line) use($item) {
            return $line['slug'] !== $item;
        }));
    }

    public function clear()
    {
        $this->session->put(self::SESSION_KEY, []);
    }

    private function increaseExistentProduct($items, $item)
    {
        return array_map(function($itemLine) use($item){
            if($item['slug'] == $itemLine['slug']) {
                $itemLine['quantity'] += $item['quantity'];
            }
            return $itemLine;
        }, $items);
    }
}
