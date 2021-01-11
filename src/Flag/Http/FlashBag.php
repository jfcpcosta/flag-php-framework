<?php namespace Flag\Http;

class FlashBag {

    const NAME = '@flag::flash_bag';

    public static function add(string $message, string $type = 'info'): void {
        $bag = Session::get(self::NAME, []);
        $bag[] = [
            'type' => $type,
            'message' => $message
        ];
        Session::set(self::NAME, $bag);
    }

    public static function has(): bool {
        return count(Session::get(self::NAME, [])) > 0;
    }

    public static function get(): array {
        $bag = Session::get(self::NAME, []);
        Session::remove(self::NAME);

        return $bag;
    }
}