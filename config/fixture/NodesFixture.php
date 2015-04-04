<?php
class NodesFixture
{

    public $fields = [
    '_constraints' =>
    [
    'primary' =>
    [
      'type' => 'primary',
      'columns' =>
      [
        0 => 'id',
      ],
      'length' =>
      [
      ],
    ],
    ],
    'id' =>
    [
    'type' => 'integer',
    'unsigned' => false,
    'null' => false,
    'default' => null,
    'comment' => '',
    'autoIncrement' => true,
    'precision' => null,
    ],
    'node_type_id' =>
    [
    'type' => 'integer',
    'length' => 11,
    'unsigned' => false,
    'null' => false,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'autoIncrement' => null,
    ],
    'node_type_slug' =>
    [
    'type' => 'string',
    'length' => 100,
    'null' => false,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'fixed' => null,
    ],
    'translation_for' =>
    [
    'type' => 'integer',
    'length' => 11,
    'unsigned' => false,
    'null' => true,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'autoIncrement' => null,
    ],
    'slug' =>
    [
    'type' => 'string',
    'length' => 100,
    'null' => false,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'fixed' => null,
    ],
    'title' =>
    [
    'type' => 'string',
    'length' => 250,
    'null' => false,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'fixed' => null,
    ],
    'description' =>
    [
    'type' => 'string',
    'length' => 200,
    'null' => true,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'fixed' => null,
    ],
    'promote' =>
    [
    'type' => 'boolean',
    'length' => null,
    'null' => false,
    'default' => '0',
    'comment' => 'Show in front page?',
    'precision' => null,
    ],
    'sticky' =>
    [
    'type' => 'boolean',
    'length' => null,
    'null' => false,
    'default' => '0',
    'comment' => 'Show at top of lists',
    'precision' => null,
    ],
    'comment_status' =>
    [
    'type' => 'integer',
    'length' => 2,
    'unsigned' => false,
    'null' => false,
    'default' => '0',
    'comment' => '0=closed, 1=open, 2=readonly',
    'precision' => null,
    'autoIncrement' => null,
    ],
    'language' =>
    [
    'type' => 'string',
    'fixed' => true,
    'length' => 10,
    'null' => true,
    'default' => null,
    'comment' => '',
    'precision' => null,
    ],
    'status' =>
    [
    'type' => 'boolean',
    'length' => null,
    'null' => false,
    'default' => null,
    'comment' => '',
    'precision' => null,
    ],
    'created' =>
    [
    'type' => 'datetime',
    'length' => null,
    'null' => false,
    'default' => null,
    'comment' => '',
    'precision' => null,
    ],
    'modified' =>
    [
    'type' => 'datetime',
    'length' => null,
    'null' => false,
    'default' => null,
    'comment' => '',
    'precision' => null,
    ],
    'created_by' =>
    [
    'type' => 'integer',
    'length' => 11,
    'unsigned' => false,
    'null' => true,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'autoIncrement' => null,
    ],
    'modified_by' =>
    [
    'type' => 'integer',
    'length' => 11,
    'unsigned' => false,
    'null' => true,
    'default' => null,
    'comment' => '',
    'precision' => null,
    'autoIncrement' => null,
    ],
    ];

    public $records = [
    0 =>
    [
    'id' => 1,
    'node_type_id' => 1,
    'node_type_slug' => 'article',
    'translation_for' => null,
    'slug' => 'hello-world',
    'title' => '¡Hello World!',
    'description' => 'hello world demo article',
    'promote' => true,
    'sticky' => false,
    'comment_status' => 1,
    'language' => '',
    'status' => true,
    'created' => '2014-06-12T07:44:01+0000',
    'modified' => '2015-04-04T03:00:33+0000',
    'created_by' => 1,
    'modified_by' => 1,
    ],
    1 =>
    [
    'id' => 2,
    'node_type_id' => 2,
    'node_type_slug' => 'page',
    'translation_for' => null,
    'slug' => 'about',
    'title' => 'About',
    'description' => 'about QuickAppsCMS demo page',
    'promote' => false,
    'sticky' => false,
    'comment_status' => 0,
    'language' => '',
    'status' => true,
    'created' => '2015-03-31T21:06:50+0000',
    'modified' => '2015-03-31T21:06:50+0000',
    'created_by' => 1,
    'modified_by' => 1,
    ],
    ];
}
