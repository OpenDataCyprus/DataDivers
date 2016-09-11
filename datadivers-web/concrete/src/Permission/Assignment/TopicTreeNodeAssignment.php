<?php

namespace Concrete\Core\Permission\Assignment;

use Concrete\Core\Tree\Node\Node;
use PermissionAccess;
use Concrete\Core\Tree\Node\Type\Topic as TopicTreeNode;
use Concrete\Core\Tree\Node\Type\TopicCategory as TopicCategoryTreeNode;
use Database;

class TopicTreeNodeAssignment extends TreeNodeAssignment
{
    protected $inheritedPermissions = array(
        'view_topic_tree_node' => 'view_topic_category_tree_node',
    );

    /**
     * @param TopicTreeNode $node
     */
    public function setPermissionObject($node)
    {
        $this->permissionObject = $node;

        if ($node->overrideParentTreeNodePermissions()) {
            $this->permissionObjectToCheck = $node;
        } else {
            $parent = Node::getByID($node->getTreeNodePermissionsNodeID());
            $this->permissionObjectToCheck = $parent;
        }
    }

    public function getPermissionAccessObject()
    {
        $db = Database::connection();
        if ($this->permissionObjectToCheck instanceof TopicTreeNode) {
            $pa = parent::getPermissionAccessObject();
        } elseif ($this->permissionObjectToCheck instanceof TopicCategoryTreeNode && isset($this->inheritedPermissions[$this->pk->getPermissionKeyHandle()])) {
            $inheritedPKID = $db->GetOne('select pkID from PermissionKeys where pkHandle = ?', array($this->inheritedPermissions[$this->pk->getPermissionKeyHandle()]));
            $r = $db->GetOne(
                'select paID from TreeNodePermissionAssignments where treeNodeID = ? and pkID = ?',
                array(
                    $this->permissionObjectToCheck->getTreeNodePermissionsNodeID(),
                    $inheritedPKID,
                )
            );
            $pa = PermissionAccess::getByID($r, $this->pk);
        } else {
            return false;
        }

        return $pa;
    }
}
