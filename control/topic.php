<?php

!defined('IN_ASK2') && exit('Access Denied');

class topiccontrol extends base {

    function topiccontrol(& $get, & $post) {
        $this->base($get, $post);
        $this->load('topic');
    }

    function ondefault() {
         $navtitle = "最新文章推荐";
        $seo_description= "推荐问答最新文章，图文展示文章内容。";
        $seo_keywords= "问答文章";
        @$page = max(1, intval($this->get[2]));
        $pagesize = $this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $rownum = $this->db->fetch_total('topic');
        $topiclist = $_ENV['topic']->get_list(2, $startindex, $pagesize);
        $departstr = page($rownum, $pagesize, $page, "topic/default");
        $metakeywords = $navtitle;
        $metadescription = '精彩推荐列表';
        $topiclist1 = $_ENV['topic']->get_list(2, 0);
        $topiclist2 = $_ENV['topic']->get_list(2, 5);
          $topiclist3 = $_ENV['topic']->get_list(2, 10);
        
        include template('topic');
    }
    function ongetone(){
     $menu="topic";
    	$topicone = $_ENV['topic']->get($this->get[2]);
    	$topicone['views']=$topicone['views']+1;
    	 $_ENV['topic']->updatetopic($topicone['id'], $topicone['title'], $topicone['describtion'],$topicone['image'],$topicone['isphone'],$topicone['views']);
    	 $navtitle = $topicone['title'];
      $metakeywords = $navtitle;
        $metadescription = $topicone['title'];
        
         $member = $_ENV['user']->get_by_uid($topicone['authorid'], 2);
          $topiclist1 = $_ENV['topic']->get_list_byuid($member['uid'],0,8);
    //if(is_mobile()){
        	// include template('getonetopic','wap');
       // }else{
        	 include template('topicone');
       // }
    }
    function onuserxinzhi(){
    	$uid=$this->get[2];
    	if($uid==null){
    		exit("非法操作");
    	}
    	 $member = $_ENV['user']->get_by_uid($uid, 2);
    $navtitle = $member['username'].'的文章列表';
        
        @$page = max(1, intval($this->get[3]));
        $pagesize = 5;//$this->setting['list_default'];
        $startindex = ($page - 1) * $pagesize;
        $rownum = $this->db->fetch_total('topic',"authorid=$uid");
        $topiclist = $_ENV['topic']->get_list_byuid($uid, $startindex, $pagesize);
        $departstr = page($rownum, 5, $page, "topic/userxinzhi/$uid");
        $metakeywords = $navtitle;
        $metadescription = $member['username'].'的文章列表';
       // if(is_mobile()){
        	// include template('userxinzhi','wap');
        //}else{
        	 include template('userxinzhi');
        //}
    }

}

?>