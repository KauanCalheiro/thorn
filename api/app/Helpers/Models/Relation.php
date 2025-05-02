<?php

namespace App\Helpers\Models;

class Relation {
    private $relatedModel;
    private $localKey;
    private $relatedKey;

    public function __construct($relatedModel, $localKey, $relatedKey = null) {
        $this->setRelatedModel($relatedModel);
        $this->setRelatedKey($relatedKey);
        $this->setLocalKey($localKey);
    }

    private function getRelatedModel() {
        return $this->relatedModel;
    }

    private function setRelatedModel($relatedModel) {
        $this->relatedModel = new $relatedModel;
    }

    private function getRelatedKey() {
        return $this->relatedKey;
    }

    private function setRelatedKey($relatedKey = null) {
        $this->relatedKey = $relatedKey ?: $this->relatedModel->getKeyName();
    }

    private function getLocalKey() {
        return $this->localKey;
    }

    private function setLocalKey($localKey) {
        $this->localKey = $localKey;
    }

    public function getQualifiedRelatedTableName() {
        return $this->relatedModel->getTable();
    }

    public function getQualifiedRelatedKeyName() {
        return $this->relatedModel->getTable() . '.' . $this->relatedKey;
    }

    public function getQualifiedParentKeyName($currentTable = null) {
        return "{$currentTable}.{$this->localKey}";
    }
}