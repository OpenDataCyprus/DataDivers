<?php
namespace Concrete\Core\Sharing\ShareThisPage;
use Concrete\Core\Page\Page;
use Concrete\Core\Sharing\SocialNetwork\Service as SocialNetworkService;
use Config;

class Service extends SocialNetworkService
{

    public static function getByHandle($ssHandle)
    {
        $services = ServiceList::get();
        foreach($services as $s) {
            if ($s->getHandle() == $ssHandle) {
                return $s;
            }
        }
    }

    public function getServiceLink(Page $c = null)
    {
        if (!is_object($c)) {
            $c = \Page::getCurrentPage();
        }
        if (is_object($c) && !$c->isError()) {
            $url = urlencode($c->getCollectionLink(true));
            switch($this->getHandle()) {
                case 'facebook':
                    return "https://www.facebook.com/sharer/sharer.php?u=$url";
                case 'twitter':
                    return "https://www.twitter.com/intent/tweet?url=$url";
                case 'linkedin':
                    $title = urlencode($c->getCollectionName());
                    return "https://www.linkedin.com/shareArticle?mini-true&url={$url}&title={$title}";
                case 'pinterest':
                    return "https://www.pinterest.com/pin/create/button?url=$url";
                case 'google_plus':
                    return "https://plus.google.com/share?url=$url";
                case 'reddit':
                    return "https://www.reddit.com/submit?url={$url}";
                case 'print':
                    return "javascript:window.print();";
                case 'email':
                    $body = rawurlencode(t("Check out this article on %s:\n\n%s\n%s", tc('SiteName', Config::get('concrete.site')), $c->getCollectionName(), urldecode($url)));
                    $subject = rawurlencode(t('Thought you\'d enjoy this article.'));
                    return "mailto:?body={$body}&subject={$subject}";
            }
        }
    }



}