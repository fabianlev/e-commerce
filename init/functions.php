<?php
function truncate($string, $max_length = 30, $replacement = '', $trunc_at_space = false){
    $max_length -= strlen($replacement);
    $string_length = strlen($string);

    if($string_length <= $max_length)
        return $string;

    if( $trunc_at_space && ($space_position = strrpos($string, ' ', $max_length-$string_length)) )
        $max_length = $space_position;

    return substr_replace($string, $replacement, $max_length);
}

function paginate($url, $link, $total, $current, $adj = 3) {
    $prev = $current - 1;
    $next = $current + 1;
    $penultimate = $total - 1;
    $pagination = '';

    if ($total > 1) {
        $pagination .= '<ul class="pagination">';

        if ($current == 2) {
            $pagination .= '<li><a href="' . $url . '">«</a></li>';
        } elseif ($current > 2) {
            $pagination .= '<li><a href="' . $url . $link . $prev . '">«</a></li>';
        } else {
            $pagination .= '<li class="disabled"><a href="#">«</a></li>';
        }

        if ($total < 7 + ($adj * 2)) {
            $pagination .= ($current == 1) ? '<li class="active"><a href="#">1  <span class="sr-only">(Actuel)</span></a></li>' : '<li><a href="'. $url . '">1</a></li>';
            for ($i=2; $i<=$total; $i++) {
                if ($i == $current) {
                    $pagination .= '<li class="active"><a href="#">' . $i. ' <span class="sr-only">(Actuel)</span></a></li>';
                } else {
                    $pagination .= '<li><a href="' . $url . $link . $i . '">' . $i . '</a></li>';
                }
            }
        }
        else {
            if ($current < 2 + ($adj * 2)) {
                $pagination .= ($current == 1) ? '<li class="active">1 <span class="sr-only">(Actuel)</span></li>' : '<li><a href="' . $url . '">1</a></li>';
                for ($i = 2; $i < 4 + ($adj * 2); $i++) {
                    if ($i == $current) {
                        $pagination .= '<li class="active">' . $i . ' <span class="sr-only">(Actuel)</span></li>';
                    } else {
                        $pagination .= '<a href="' . $url . $link . $i . '"> ' .$i . '</a>';
                    }
                }
                $pagination .= '<li><a href="#">&hellip;</a></li>';
                $pagination .= '<li><a href="' . $url . $link . $penultimate .'">' . $penultimate . '</a></li>';
                $pagination .= '<li><a href="' . $url . $link . $total . '">' . $total . '</a></li>';
            }
            elseif ( (($adj * 2) + 1 < $current) && ($current < $total - ($adj * 2)) ) {
                $pagination .= '<li><a href="' . $url . '">1</a></li>';
                $pagination .= '<li><a href="' . $url . $link . '2">2</a></li>';
                $pagination .= '&hellip;';
                for ($i = $current - $adj; $i <= $current + $adj; $i++) {
                    if ($i == $current) {
                        $pagination .= '<li class="active">' . $i . ' <span class="sr-only">(Actuel)</span></li>';
                    } else {
                        $pagination .= '<a href="' . $url . $link . $i . '">' . $i . '</a>';
                    }
                }

                $pagination .= '<li><a href="#">&hellip;</a></li>';
                $pagination .= '<li><a href="' . $url . $link . $penultimate . '">' . $penultimate . '</a></li>';
                $pagination .= '<li><a href="' . $url . $link . $total . '">' . $total . '</a></li>';
            }
            else {
                $pagination .= '<li><a href="' . $url . '">1</a></li>';
                $pagination .= '<li><a href="' . $url . $link . '2">2</a></li>';
                $pagination .= '<li><a href="#">&hellip;</a></li>';
                for ($i = $total - (2 + ($adj * 2)); $i <= $total; $i++) {
                    if ($i == $current) {
                        $pagination .= '<li class="active">' . $i . ' <span class="sr-only">(Actuel)</span></li>';
                    } else {
                        $pagination .= '<li><a href="' . $url . $link . $i . '">' . $i . '</a></li>';
                    }
                }
            }
        }
        if ($current == $total){
            $pagination .= '<li class="disabled"><a href="#">»</a></li>';
        }else{
            $pagination .= '<li><a href="' . $url . $link . $next . '">»</a></li>';
        }
        $pagination .= "</ul>\n";
    }

    return ($pagination);
}

function noFilter($url){
    $tmpLink = str_replace('&price=ASC', '', $url);
    $tmpLink = str_replace('&price=DESC', '', $tmpLink);
    $tmpLink = str_replace('&name=ASC', '', $tmpLink);
    return str_replace('&name=DESC', '', $tmpLink);
}

function filter($url, $filter , $order='ASC'){
    if($order != ('ASC' || 'DESC')){
        return false;
    }
    $fromFilter = $order == 'ASC' ? 'DESC' : 'ASC';
    $tmp = str_replace("&$filter=$order", '', $url);
    return str_replace("&$filter=$fromFilter", '', $tmp) . "&$filter=$order";
}