<?php

namespace Zombie;

class Paginator
{
    /**
     * Number of page
     *
     * @var int
     */
    private $page = 1;

    /**
     * Count of link for pagination
     *
     * @var int
     */
    private $count_of_links = 3;

    /**
     * Count of showed elements on page
     *
     * @var int
     */
    private $count_of_show = 3;

    /**
     * Total count of items
     *
     * @var
     */
    private $count_of_items;

    /**
     * Total count of pages
     *
     * @var int
     */
    private $count_pages;

    /**
     * Links on the left side from current page number
     *
     * @var int
     */
    private $left;

    /**
     * Links on the right side from current page number
     *
     * @var int
     */
    private $right;

    /**
     * Delta
     *
     * @var int
     */
    private $delta = 1;

    /**
     * Query parameters without page number
     *
     * @var string
     */
    private $queryParams;

    /**
     * Paginator constructor.
     * @param $count_of_show
     * @param $page
     * @param $count_of_links
     * @param $count_of_items
     */
    public function __construct($count_of_show, $page, $count_of_links, $count_of_items)
    {
        $this->page = $page;
        $this->count_of_show = $count_of_show;
        $this->count_of_links = $count_of_links;
        $this->count_of_items = $count_of_items;
        $this->left = $this->page - $this->delta;
        $this->right = $this->page + $this->delta + 1;
        $this->count_pages = (int) ceil($this->count_of_items / $this->count_of_show);
        $this->queryParams = $this->concatQueryParams();
    }

    /**
     * Generate html for page
     *
     * @return string
     */
    public function links()
    {
        return '<div class="container">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            ' . $this->previous() . '
                            ' . $this->nums() . '
                            ' . $this->next() . '
                        </ul>
                    </nav>
                </div>';
    }

    /**
     * Get query parameters from request excluding page parameter
     *
     * @return string
     */
    private function concatQueryParams()
    {
        $query = request()->queryAll();
        $result = '';

        foreach($query as $key => $item)
            if ($key !== 'page')
                $result .= '&' . $key . '=' . $item;

        return $result;
    }

    /**
     * Generate links for pagination
     *
     * @return string
     */
    private function nums()
    {
        $html = '';

        for($i = 1; $i <= $this->count_pages; $i++) {
            if ($i == 1 || $i == $this->count_pages || $i >= $this->left || $i < $this->right) {
                if ($i === $this->page)
                    $html .= '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);">' . $i . '</a></li>';
                else $html .= '<li class="page-item"><a class="page-link" href="/?page=' . $i . $this->queryParams . '">' . $i . '</a></li>';
            }
        }

        return $html;
    }

    /**
     * Generate previous button
     *
     * @return string
     */
    private function previous()
    {
        if ($this->page === 1)
            return '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Previous</a></li>';

        return '<li class="page-item"><a class="page-link" href="/?page=' . ($this->page - 1) . $this->queryParams . '">Previous</a></li>';
    }

    /**
     * Generate next button
     *
     * @return string
     */
    private function next()
    {
        if ((int) ceil($this->count_of_items / $this->count_of_show) === $this->page)
            return '<li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Next</a></li>';

        return '<li class="page-item"><a class="page-link" href="/?page=' . ($this->page + 1) . $this->queryParams . '">Next</a></li>';
    }
}