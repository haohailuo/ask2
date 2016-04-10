<?php

!defined('IN_ASK2') && exit('Access Denied');

class indexcontrol extends base {

    function indexcontrol(& $get, & $post) {
        $this->base($get, $post);
    }

    function ondefault() {
    	
        $linklist = $this->cache->load('link', 'id', 'displayorder');
        /* SEO */
        $this->setting['seo_index_title'] && $seo_title = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_index_title']);
        $this->setting['seo_index_description'] && $seo_description = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_index_description']);
        $this->setting['seo_index_keywords'] && $seo_keywords = str_replace("{wzmc}", $this->setting['site_name'], $this->setting['seo_index_keywords']);

//         global $setting;
//     $this->load('topic');
//              $topiclist = $_ENV['topic']->get_list(2, 1, 5);
//               if(is_mobile()||$_SERVER['HTTP_HOST']==$setting['wap_domain']){
//  $this->load('topic');
//   $topiclistinphone = $_ENV['topic']->get_list_bywhere(2,5);
//	 include template('index','wap');
//}else{
//        include template('index');
//}
 include template('index');
    }
   

    function onhelp() {
        $this->load('usergroup');
        $usergrouplist = $_ENV['usergroup']->get_list(2);
        include template('help');
    }

    function ondoing() {
        include template("doing");
    }
     function onnotfound(){
     	  include template("404");
     }
    /* 查询图片是否需要点击放大 */

    function onajaxchkimg() {
        list($width, $height, $type, $attr) = getimagesize($this->post['imgsrc']);
        ($width > 300) && exit('1');
        exit('-1');
    }

    function ononline() {
        $navtitle = "当前在线";
        $this->load('user');
        @$page = max(1, intval($this->get[2]));
        $pagesize = 30;
        $startindex = ($page - 1) * $pagesize;
        $onlinelist = $_ENV['user']->list_online_user($startindex, $pagesize);
        $onlinetotal = $_ENV['user']->rownum_onlineuser();
        $departstr = page($onlinetotal, $pagesize, $page, "index/online");
        include template("online");
    }

}

?>