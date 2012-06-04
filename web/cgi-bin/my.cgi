#!/usr/bin/perl
	$ENV{REQUEST_URI} =~ m#^(.+)/[^/]+?$#; # untaint
print $1
