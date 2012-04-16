<?php
namespace UNL\VisitorChat\OperatorRegistry\WDN;

class Site implements \UNL\VisitorChat\OperatorRegistry\SiteInterface
{
    private $url     = null;
    
    private $members = array();
    
    private $email   = null;
    
    private $title   = null;
    
    function __construct($url, $data)
    {
        $this->url   = $url;
        
        if (isset($data['title'])) {
            $this->title = $data['title'];
        }
        
        if (isset($data['members'])) {
            $this->members = $data['members'];
        }
        
        if (isset($data['email'])) {
            $this->email = $data['email'];
        }
    }
    
    function getURL()
    {
        return $this->url;
    }
    
    function getMembers()
    {
        return new Site\MemberList($this->url, $this->members);
    }
    
    function getEmail()
    {
        if ($this->email !== null) {
            return $this->email;
        }
        
        foreach ($this->getMembers() as $person) {
            $person = new \UNL\VisitorChat\Site\Member($person);
            $email = "";
            if ($mail = $person->getEmail()) {
                $email .= $mail . ', ';
            }
        }
        
        return $email;
    }
    
    function getTitle()
    {
        return $this->title;
    }
}