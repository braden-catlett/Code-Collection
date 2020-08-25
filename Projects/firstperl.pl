#/usr/bin/perl
use feature qw(say);
#(@array, $first, $last)
sub MergeSort{
	@array = shift;
	say $#array;
	if(($#array + 1) > 1){
		$Index = ($#array + 1) / 2;
		@firsthalf = @array[0..$Index - 1];
		@secondhalf = @array[$Index..($#array + 1)];
		MergeSort(\@firsthalf);
		MergeSort(\@secondhalf);
		$current1 = 0;
		$current2 = 0;
		@temp = ();
		while($current1 < ($#firsthalf + 1) && $current2 < ($#secondhalf + 1)){
			if(@firsthalf[$current1] < @secondhalf[$current2]){
				push(@temp, @firsthalf[$current1++]);
			}
			else{
				push(@temp, @secondhalf[$current2++]);
			}
		}
		while($current1 < ($#firsthalf + 1)){
			push(@temp, @firsthalf[$current1++]);
		}
		while($current2 < ($#secondhalf + 1)){
			push(@temp, @secondhalf[$current2++]);
		}
		@array = @temp;
	}
}
package main;
use strict;
use warnings;
use feature qw(say);
my @items = ("Brad", "Becca", "Kellen", "Cam", "Sly");
my @nums = (1,5,4,7,10,8,6,3,9,8);
MergeSort(@nums);
say @nums;