<?php
class plugin_page{
    public function __construct()
    {
        $this->cur_page  = 1;
        $this->page_size = 10;
        $this->pages     = array();
    }

    public function getStaticPage($param)
    {
        $this->pages       = array();
        $this->base_url    = $param['base_url'];
        $this->total_count = $param['total_count'];

        if(isset($param['page_size']) && $param['page_size']){
            $this->page_size = $param['page_size'];
        }

        if(isset($param['cur_page']) && $param['cur_page']){
            $this->cur_page  = intval($param['cur_page']);
        }

        $this->page_count  = ceil($this->total_count/$this->page_size);

        if($this->page_count == 1) return '';

        //确定起始位置
        if($this->cur_page<=5)
            $limit_s = 1;
        else
            $limit_s = $this->cur_page-4;

        //确定结束位置
        if($this->page_count>=$this->cur_page+4)
            $limit_e = $this->cur_page+4;
        else
            $limit_e = $this->page_count;

        //确保显示9个页码
        if($this->cur_page < 9 && $limit_e < 9){
            if($this->page_count >= 9)
                $limit_e = 9;
            else
                $limit_e = $this->page_count;
        }

        //生成html代码
        if($this->cur_page>1){
            $url = $this->base_url.($this->cur_page-1).'.html';
            $this->pages[] = '<li class="prev first"><a href="'.$url.'"> Prev</a></li>';
        }

        for($i = $limit_s; $i<$limit_e+1; $i++){
            if($this->cur_page == $i){
                $url = $this->base_url.$i.'.html';
                $this->pages[] = '<li class="active"><span>'.$this->cur_page.'</span></li>';
            }else{
                $url = $this->base_url.$i.'.html';
                $this->pages[] = '<li><a href="'.$url.'">'.$i.'</a></li>';
            }
        }

        if($this->cur_page<$this->page_count){
            $url = $this->base_url.$i.'.html';
            $this->pages[] = '<li class="next last"><a href="'.$url.'">Next </a></li>';
        }

        $pages = implode('', $this->pages);
        return '<ul>'.$pages.'</ul>';
    }

    public function getPage($param)
    {
        $this->base_url    = $param['base_url'];
        $this->total_count = $param['total_count'];

        if(isset($param['page_size']) && $param['page_size']){
            $this->page_size = $param['page_size'];
        }

        if(isset($param['cur_page']) && $param['cur_page']){
            $this->cur_page  = intval($param['cur_page']);
        }

        $this->page_count  = ceil($this->total_count/$this->page_size);

        if($this->page_count == 1) return '';

        //确定起始位置
        if($this->cur_page<=5)
            $limit_s = 1;
        else
            $limit_s = $this->cur_page-4;

        //确定结束位置
        if($this->page_count>=$this->cur_page+4)
            $limit_e = $this->cur_page+4;
        else
            $limit_e = $this->page_count;

        //确保显示9个页码
        if($this->cur_page < 9 && $limit_e < 9){
            if($this->page_count >= 9)
                $limit_e = 9;
            else
                $limit_e = $this->page_count;
        }

        //生成html代码
        if($this->cur_page>1){
            $this->pages[] = '<li class="prev first"><a href="'.$this->base_url.'?page='.($this->cur_page-1).'"> Prev</a></li>';
        }

        for($i = $limit_s; $i<$limit_e+1; $i++){
            if($this->cur_page == $i)
                $this->pages[] = '<li class="active"><span>'.$this->cur_page.'</span></li>';
            else
                $this->pages[] = '<li><a href="'.$this->base_url.'?page='.$i.'">'.$i.'</a></li>';
        }

        if($this->cur_page<$this->page_count)
            $this->pages[] = '<li class="next last"><a href="'.$this->base_url.'?page='.$i.'">Next </a></li>';

        $pages = implode('', $this->pages);
        return '<ul>'.$pages.'</ul>';
    }

}

?>
