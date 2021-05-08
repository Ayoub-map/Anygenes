 
 <?php
    function endsWith($string, $endString)
    {
        $len = strlen($endString);
        if ($len == 0) {
            return true;
        }
        return (substr($string, -$len) === $endString);
    }



    function getCrumbsPage($post, $page)
    {
        if ($page == 'fr') {
            $home = 'ACCEUIL';
        } else {
            $home = 'HOME';
        }
        $id_parent = wp_get_post_parent_id($post);
        $id_parent2 = $post->ID;
        $ids_page = array();
        array_push($ids_page, $id_parent2);
        array_push($ids_page, $id_parent);
        $post_parent = get_the_title($post->post_parent);
            while ($post_parent != $home) {
                $id_parent = wp_get_post_parent_id($id_parent);
                $post_parent = get_the_title($id_parent);
                if ($post_parent != $home) {
                    array_push($ids_page, $id_parent);
                }
        }
      
        return array_reverse($ids_page);
    }
    ?>