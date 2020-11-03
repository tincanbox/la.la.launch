<?php

namespace App\Models\Traits;

trait HasMeta
{

    function generateMetaRelationArray()
    {
        $thisModelPath = get_class($this);
        $metaModelPath = $thisModelPath.'Meta';
        return [$thisModelPath, $metaModelPath];
    }

    function createMeta()
    {
        $rel = $this->generateMetaRelationArray();
        $thisModelName = class_basename($rel[0]);
        $metaModelPath = $rel[1];
        $meta = new $metaModelPath;
        $fk = strtolower($thisModelName).'_id';
        $meta->{$fk} = $this->id;
        $meta->save();
        return $meta;
    }

    function meta()
    {
        $rel = $this->generateMetaRelationArray();
        return $this->hasOne($rel[1]);
    }
}
