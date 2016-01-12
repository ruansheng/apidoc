<?php
/**
 * @name Pager
 * @author ruansheng
 * @desc PagerLib::getPager(100,10,1)
 */
class PagerLib {

    public static $data_count_str = '总数据';
    public static $page_count_str = '总页数';
    public static $prev_page_str = '上一页';
    public static $next_page_str = '下一页';

    /**
     * @param $data_count int   总数据
     * @param $row_count  int   每页的数据
     * @param $now_page  int    当前页数
     * @return array|string
     */
    public static function getPager($data_count, $row_count, $now_page = 1) {
        if(empty($data_count) || empty($row_count) || empty($now_page)) { //判断参数合法性
            return [];
        }

        if(!is_numeric($data_count) || !is_numeric($row_count) || !is_numeric($now_page)) {
            return [];
        }

        //计算总页数
        $page_count = ceil($data_count / $row_count);

        if($now_page > $page_count) {  //当前页大于总页数
            return [];
        }

        $pagers = '';
        $pagers .= '<div class="pager-box">';
        $pagers .= '<span class="data-count">' . self::$data_count_str . $data_count . '</span>';
        $pagers .= '<span class="page-count">' . self::$page_count_str . $page_count . '</span>';

        if($now_page == 1) {
            $pagers .= '<a class="prev-pager" href="?p=1">' . self::$prev_page_str . '</a>';
        } else {
            $pagers .= '<a class="prev-pager" href="?p=' . ($now_page-1) . '">' . self::$prev_page_str . '</a>';
        }
        $pagers .= '<span class="pager">';
        for($i=1; $i <= $page_count; $i++) {
            if($page_count <= 9) {
                if($i == $now_page) {
                    $pagers .= '<a class="now-pager" href="?p=' . $i . '">' . $i . '</a>';
                }else {
                    $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                }
            } else {
                if($now_page <= 8) {
                    if($i <= 8) {
                        if ($i == $now_page) {
                            $pagers .= '<a class="now-pager" href="?p=' . $i . '">' . $i . '</a>';
                        } else {
                            $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                        }
                    } else if($i == 9){
                        $pagers .= '<a href="javascript:void(0);">...</a>';
                    } else if($i == $page_count){
                        $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                    }
                } else {
                    if($i == 1) {
                        $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                    } else if($i == $page_count){
                        $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                    } else if($i >= ($now_page - 3) && $i <= ($now_page + 3)) {
                        if ($i == $now_page) {
                            $pagers .= '<a class="now-pager" href="?p=' . $i . '">' . $i . '</a>';
                        } else {
                            $pagers .= '<a href="?p=' . $i . '">' . $i . '</a>';
                        }
                    } else if($i == ($now_page - 4) || $i == ($now_page + 4)) {
                        $pagers .= '<a href="javascript:void(0);">...</a>';
                    }
                }
            }
        }
        $pagers .= '</span>';
        if($now_page == 1) {
            $pagers .= '<a class="next-pager" href="?p=1">' . self::$next_page_str . '</a>';
        } else {
            $pagers .= '<a class="next-pager" href="?p=' . ($now_page+1) . '">' . self::$next_page_str . '</a>';
        }

        $pagers .= '</div>';

        $pobj = [
            'data_count' => $data_count,
            'row_count' => $row_count,
            'page_count' => $page_count,
            'now_page' => $now_page,
            'pagers' => $pagers
        ];

        return $pobj;
    }
}
