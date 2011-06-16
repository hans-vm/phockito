<?php
require_once 'Hamcrest/AbstractMatcherTest.php';
require_once 'Hamcrest/Array/IsArrayContainingInOrder.php';

class Hamcrest_Array_IsArrayContainingInOrderTest
  extends Hamcrest_AbstractMatcherTest
{
  
  protected function createMatcher()
  {
    return Hamcrest_Array_IsArrayContainingInOrder::arrayContaining(array(equalTo(1), equalTo(2)));
  }
  
  public function testHasAReadableDescription()
  {
    $this->assertDescription('[<1>, <2>]', arrayContaining(array(equalTo(1), equalTo(2))));
  }
  
  public function testMatchesItemsInOrder()
  {
    $this->assertMatches(arrayContaining(array(1, 2, 3)), array(1, 2, 3), 'in order');
    $this->assertMatches(arrayContaining(array(1)), array(1), 'single');
  }
  
  public function testAppliesMatchersInOrder()
  {
    $this->assertMatches(
      arrayContaining(array(equalTo(1), equalTo(2), equalTo(3))),
      array(1, 2, 3),
      'in order'
    );
    $this->assertMatches(arrayContaining(array(equalTo(1))), array(1), 'single');
  }
  
  public function testMismatchesItemsInAnyOrder()
  {
    $matcher = arrayContaining(array(1, 2, 3));
    $this->assertMismatchDescription('was null', $matcher, null);
    $this->assertMismatchDescription('No item matched: <1>', $matcher, array());
    $this->assertMismatchDescription('No item matched: <2>', $matcher, array(1));
    $this->assertMismatchDescription('item with key 0: was <4>', $matcher, array(4, 3, 2, 1));
    $this->assertMismatchDescription('item with key 2: was <4>', $matcher, array(1, 2, 4));
  }
  
}
