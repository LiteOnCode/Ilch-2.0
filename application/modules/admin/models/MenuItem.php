<?php
/**
 * Holds class Menu.
 *
 * @copyright Ilch 2.0
 * @package ilch
 */

namespace Admin\Models;
defined('ACCESS') or die('no direct access');

/**
 * The menu item model class.
 *
 * @package ilch
 */
class MenuItem extends \Ilch\Model
{
    /**
     * Id of the item.
     *
     * @var integer
     */
    protected $_id;
    
    /**
     * Type of the item.
     *
     * @var integer
     */
    protected $_type;
    
    /**
     * Siteid of the item.
     *
     * @var integer
     */
    protected $_siteId;

    /**
     * MenuId of the item.
     *
     * @var integer
     */
    protected $_menuId;

    /**
     * ParentId of the item.
     *
     * @var integer
     */
    protected $_parentId;

    /**
     * Title of the item.
     *
     * @var string
     */
    protected $_title;

    /**
     * Href of the item.
     *
     * @var string
     */
    protected $_href;

    /**
     * Gets the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets the id.
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->_id = (int) $id;
    }
    
    /**
     * Gets the type.
     *
     * @return integer
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * Sets the type.
     *
     * @param integer $id
     */
    public function setType($type)
    {
        $this->_type = (int)$type;
    }
    
    /**
     * Gets the key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->_key;
    }

    /**
     * Sets the key.
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->_key = (string)$key;
    }
    
    /**
     * Gets the siteid.
     *
     * @return integer
     */
    public function getSiteId()
    {
        return $this->_siteId;
    }

    /**
     * Sets the siteid.
     *
     * @param integer $id
     */
    public function setSiteId($id)
    {
        $this->_siteId = (int)$id;
    }

    /**
     * Gets the menu id.
     *
     * @return integer
     */
    public function getMenuId()
    {
        return $this->_menuId;
    }

    /**
     * Sets the menu id.
     *
     * @param integer $id
     */
    public function setMenuId($id)
    {
        $this->_menuId = (int) $id;
    }

    /**
     * Gets the parent id.
     *
     * @return integer
     */
    public function getParentId()
    {
        return $this->_parentId;
    }

    /**
     * Sets the parent id.
     *
     * @param integer $id
     */
    public function setParentId($id)
    {
        $this->_parentId = (int) $id;
    }

    /**
     * Gets the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * Sets the title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->_title = (string) $title;
    }

    /**
     * Gets the href.
     *
     * @return string
     */
    public function getHref()
    {
        return $this->_href;
    }

    /**
     * Sets the href.
     *
     * @param string $href
     */
    public function setHref($href)
    {
        $this->_href = (string) $href;
    }
}
