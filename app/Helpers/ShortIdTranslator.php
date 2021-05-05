<?php

namespace App\Helpers;

use App\Models\DatabaseFile;
use App\Models\ShortId;

class ShortIdTranslator 
{
    public function trans($file_id, $model_id, $group, $type, $pos = null) {
        if ($model_id == null) {
            return '';
        }

        $model = ShortId::where(['file_id' => $file_id, 'model_id' => $model_id]);
        if ($model->exists()) {
            return $model->first()->short_id;
        }

        if ($pos == null) {
            $position = $type::all()->search(function ($model, $key) use ($model_id) {
                return $model->sId == $model_id;
            }) + 1;
        } else {
            $position = $pos;
        }

        return ShortId::create([
            'file_id' => $file_id,
            'model_id' => $model_id,
            'group' => $group,
            'type' => $type,
            'short_id' => sprintf("%s_%d", $group, $position),
        ])->short_id;
    }

    public function retrieve($file_id, $model_id) : string {
        $result = ShortId::where(['file_id' => $file_id, 'model_id' => $model_id])->first();
        if ($result == null) {
            return 'Probíhá substituce ...';
        }

        return $result->short_id;
    }

    public function delete(DatabaseFile $database) {
        return ShortId::where('file_id', $database->url)->delete();
    }
}
