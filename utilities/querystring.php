<?php

/**
 * Query String Object
 *
 *  PHP version 4
 *
 *  @category Utility
 *  @package  Utility
 *  @author   Isaque Bressy <isaquebressy@gmail.com>
 *  @license  https://www.gnu.org/licenses/gpl.html GNU
 *  @version  GIT: 0.0.1
 */
class QueryString {

    public $where;
    public $limit;
    public $offset;
    public $sort;

    private function getFilterQuery() {
        $sql = '';
        if ($this->where != null && is_array($this->where)) {
            foreach ($this->where as $key => $value) {
                // search for parameters...
                if (!is_numeric($value)) {
                    $sql .= " AND $key LIKE '%$value%'";
                } else {
                    $sql .= " AND $key=$value";
                }
            }
        }
        return $sql;
    }

    private function getSortQuery() {
        $sql = '';
        if ($this->sort != null) {
            $order = 'ASC';
            if ($this->sort[0] == '-') {
                $order = 'DESC';
                $this->sort = ltrim($this->sort, '-');
            }

            $sql .= " ORDER BY $this->sort $order";
        }
        return $sql;
    }

    private function getLimitQuery() {
        $sql = '';

        if ($this->limit != null && $this->limit > 0) {
            $sql .= " LIMIT $this->limit";

            if ($this->offset != null && $this->offset > 0) {
                $sql .= " OFFSET $this->offset";
            }
        }

        return $sql;
    }

    public function getQuery() {
        $sql = '';
        $sql .= $this->getFilterQuery();
        $sql .= $this->getSortQuery();
        $sql .= $this->getLimitQuery();

        return $sql;
    }

}
