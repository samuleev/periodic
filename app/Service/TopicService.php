<?php

namespace App\Service;

use Illuminate\Support\Facades\DB;

class TopicService {

    static function getByIds(array $topicIds)
    {
        return DB::table('topic')
            ->whereIn('topic_id', $topicIds)->get();
    }

}