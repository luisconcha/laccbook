<?php
return [
  'name' => 'LaccBook',
  'acl'  => [
    'role_author'             => env( 'ROLE_AUTHOR', 'Author' ),
    'controllers_annotations' => [
      __DIR__ . '/../Http/Controllers',
    ],
  ],
];
