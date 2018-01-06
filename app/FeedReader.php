<?php

namespace App;

use SimpleXMLElement;

class FeedReader
{

    /** @var SimpleXMLElement */
    protected $xml;

    /**
     * Loads RSS channel.
     * @param  string  RSS feed URL
     * @return FeedReader
     * @throws Exception
     */
    public static function loadRss($url)
    {
        $xml = new SimpleXMLElement(file_get_contents($url), LIBXML_NOWARNING | LIBXML_NOERROR);

        if (!$xml->channel) {
            throw new Exception('Invalid channel.');
        }

        self::adjustNamespaces($xml->channel);

        foreach ($xml->channel->item as $item) {
            // converts namespaces to dotted tags
            self::adjustNamespaces($item);
            // generate 'timestamp' tag
            if (isset($item->{'dc:date'})) {
                $item->timestamp = strtotime($item->{'dc:date'});
            } elseif (isset($item->pubDate)) {
                $item->timestamp = strtotime($item->pubDate);
            }
        }
        $feedReader = new self;
        $feedReader->xml = $xml->channel;
        return $feedReader;
    }

    /**
     * Generates better accessible namespaced tags.
     * @param  SimpleXMLElement
     * @return void
     */
    private static function adjustNamespaces($el)
    {
        foreach ($el->getNamespaces(TRUE) as $prefix => $ns) {
            $children = $el->children($ns);
            foreach ($children as $tag => $content) {
                $el->{$prefix . ':' . $tag} = $content;
            }
        }
    }

    /**
     * Returns property value. Do not call directly.
     * @param  string  tag name
     * @return SimpleXMLElement
     */
    public function __get($name)
    {
        return $this->xml->{$name};
    }

    /**
     * Sets value of a property. Do not call directly.
     * @param  string  property name
     * @param  mixed   property value
     * @return void
     */
    public function __set($name, $value)
    {
        throw new Exception("Cannot assign to a read-only property '$name'.");
    }

}