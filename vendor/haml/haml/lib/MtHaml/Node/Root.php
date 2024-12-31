<?php

namespace MtHaml\Node;

use MtHaml\Helpers\Position;
use MtHaml\NodeVisitor\NodeVisitorInterface;

class Root extends NestAbstract
{
  public function __construct(Position $position = null)
  {
      parent::__construct($position ?: new Position());
  }

  public function getNodeName()
  {
    return 'root';
  }

  public function accept(NodeVisitorInterface $visitor)
  {
      if (false !== $visitor->enterRoot($this)) {

          if (false !== $visitor->enterRootContent($this)) {
              $this->visitContent($visitor);
          }
          $visitor->leaveRootContent($this);

          if (false !== $visitor->enterRootChilds($this)) {
              $this->visitChilds($visitor);
          }
          $visitor->leaveRootChilds($this);
      }
      $visitor->leaveRoot($this);
  }
}

