<?php

function print_head($response, $count = 2): void
{
    if (isset($response['fetched_data_count'])) {
        dump('total : ' . $response['fetched_data_count']);
    }
    if (isset($response['data']['data'])) {
        dump('head of data =>', collect($response['data']['data'])->take($count)->toArray());
    } elseif (isset($response['data'])) {
        dump($response['data']);
    } else {
        dump($response);
    }

}
