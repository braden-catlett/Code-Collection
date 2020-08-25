/*Declares is_player and is_monster as dynamic so assert and retract can operate*/
dynamic(is_player/1).
dynamic(is_monster0/1).
dynamic(is_monster1/1).
dynamic(is_monster2/1).
/*Set up the facts containing all legal positions in maze*/
/*First Column*/
is_clear(1).
is_clear(21).
is_clear(41).
is_clear(51).
is_clear(61).
is_clear(91).
is_clear(101).
/*Second Column*/
is_clear(2).
is_clear(22).
is_clear(42).
is_clear(62).
is_clear(72).
is_clear(82).
is_clear(92).
/*Third Column*/
is_clear(3).
is_clear(13).
is_clear(23).
is_clear(43).
/*Fourth Column*/
is_clear(4).
is_clear(44).
is_clear(54).
is_clear(64).
is_clear(74).
is_clear(84).
is_clear(94).
is_clear(104).
/*Fifth Column*/
is_clear(5).
is_clear(15).
is_clear(25).
is_clear(35).
is_clear(45).
is_clear(65).
is_clear(105).
/*Sixth Column*/
is_clear(6).
is_clear(26).
is_clear(46).
is_clear(56).
is_clear(66).
is_clear(96).
is_clear(106).
/*Seventh Column*/
is_clear(7).
is_clear(27).
is_clear(47).
is_clear(67).
is_clear(97).
/*Eighth Column*/
is_clear(8).
is_clear(38).
is_clear(48).
is_clear(68).
is_clear(98).
is_clear(108).
/*Ninth Column*/
is_clear(9).
is_clear(49).
is_clear(109).
/*Tenth Column*/
is_clear(10).
is_clear(30).
is_clear(40).
is_clear(50).
is_clear(60).
is_clear(70).
is_clear(110).
/*End of maze path facts*/

/*Starting position for player/Prolog side place holder*/
is_player(1).

/*Positions of all doors*/
/*Query for if a door is in the way
If so then prevent passage until action button is pressed
No check for open or not, Just place the player past the door
when action button is pressed*/
is_door(33).
is_door(73).
is_door(9).

/*Positions of all chests*/
/*If so then prevent passage until action button is pressed
If pressed then the chest will "open" and the player will receive an item
Most likely a weapon or health
Might need a is_open check to prevent multiple opens*/
is_chest(102).

/*Position of Monsters within Maze*/
/*Might not be necessary but will be the same type of procedure
as is_player() being updated through out the game*/
is_monster0(5).
is_monster1(64).
is_monster2(109).

/*Rules*/
/*Name: checkposition
 *Input: Starting Position
 *Output: Whether or not moving to that position would be valid*/
check_position_north(X,Y):- X2 is X-10,is_clear(X2),X2 = Y.
check_position_south(X,Y):- X2 is X+10,is_clear(X2),X2 = Y.
check_position_east(X,Y):- X2 is X-1,is_clear(X2),X2 = Y.
check_position_west(X,Y):- X2 is X+1,is_clear(X2),X2 = Y.

/*Name: findmove(Three Directions)
 *Input: Starting Position,Variable to contain the next position number
 *Output: The Position number
 *Used with findbestmove in which the directions is calculated and then one
 *of these is chosen based off that directions to determine the best next move
 *without going in the opposite direction*/
findmoveEWS(X,Y):- check_position_east(X,Y);
check_position_west(X,Y);
check_position_south(X,Y).

findmoveNSW(X,Y):- check_position_north(X,Y);
check_position_south(X,Y);
check_position_west(X,Y).

findmoveEWN(X,Y):- check_position_east(X,Y);
check_position_west(X,Y);
check_position_north(X,Y).

findmoveNSE(X,Y):- check_position_north(X,Y);
check_position_south(X,Y);
check_position_east(X,Y).

/*Name: findbestmove
 *Input: Old position, Current Position, X to store the new position, Y
 *to store flag for special events
 *Output: The next position to go to and the flag for special events
 *This is the Omni-Rule which is used to intelligently determine a good
 *move to take. Usually will probably only take the first solution to
 *this query
 */
findbestmove(Old,Curr,X,Y):-
Temp is Curr-10, is_player(Temp), X is Temp, Y is 1;
Temp is Curr+1, is_player(Temp), X is Temp, Y is 1;
Temp is Curr+10, is_player(Temp), X is Temp, Y is 1;
Temp is Curr-1, is_player(Temp), X is Temp, Y is 1;
(Curr-Old) =:= -10, is_clear(Curr+1),X is Curr+1,Y is 0;
(Curr-Old) =:= -10, is_clear(Curr-1),X is Curr-1,Y is 0;
(Curr-Old) =:= 1, is_clear(Curr+10),X is Curr+10,Y is 0;
(Curr-Old) =:= 1, is_clear(Curr-10),X is Curr-10,Y is 0;
(Curr-Old) =:= 10, is_clear(Curr-1),X is Curr-1,Y is 0;
(Curr-Old) =:= 10, is_clear(Curr+1),X is Curr+1,Y is 0;
(Curr-Old) =:= -1, is_clear(Curr-10),X is Curr-10,Y is 0;
(Curr-Old) =:= -1, is_clear(Curr+10),X is Curr+10,Y is 0;
Temp is Curr+Curr-Old, is_clear(Temp), X is Temp, Y is 0;
(Curr-Old) =:= -10, findmoveEWS(Curr,X), Y is 0;
(Curr-Old) =:= 1, findmoveNSW(Curr,X), Y is 0;
(Curr-Old) =:= 10, findmoveEWN(Curr,X), Y is 0;
(Curr-Old) =:= -1, findmoveNSE(Curr,X), Y is 0.






