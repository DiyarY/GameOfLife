# Conways Game of Life in PHP 
___


# Genral infos about the Game of Life <br><br>

If you're unfamiliar with the Conways Game of Life then checkout the Wikipedia Link below <br>
where you'll find all needed information for it:

> English version: https://en.wikipedia.org/wiki/Conway%27s_Game_of_Life <br>
> German version: https://de.wikipedia.org/wiki/Conways_Spiel_des_Lebens
___

## Rules

Conways Game of Life is two-dimensional grid of squares and cells, where each cell <br>
has two possible states, alive or dead. Each cell interacts with its eight neighbours, <br>
which are the cells that are horizontally, vertically or diagonally adjacent.

1. Any live cell with fewer than two live neighbours dies, as if caused by under-population. <br>
2. Any live cell with two or three live neighbours lives on to the next generation. <br>
3. Any live cell with more than three live neighbours dies, as if by overcrowding. <br>
4. Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
___


## Output of the grid and generations

***Living cells are marked with " * " and dead cells with " - "***

```PHP
Generation: 0
 -  -  -  -  -  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -
 -  *  *  -  -  -  -  -  -  -
 *  *  -  *  -  -  -  -  -  -
 -  -  *  -  *  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -
 -  -  -  *  *  -  -  -  -  -
 -  -  -  *  -  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -


Generation: 1
 -  -  -  -  -  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -
 *  *  *  -  -  -  -  -  -  -
 *  -  -  *  -  -  -  -  -  -
 -  *  *  *  -  -  -  -  -  -
 -  -  -  -  *  -  -  -  -  -
 -  -  -  *  *  -  -  -  -  -
 -  -  -  *  *  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -


Generation: 2
 -  -  -  -  -  -  -  -  -  -
 -  *  -  -  -  -  -  -  -  -
 *  *  *  -  -  -  -  -  -  -
 *  -  -  *  -  -  -  -  -  -
 -  *  *  *  *  -  -  -  -  -
 -  -  -  -  *  -  -  -  -  -
 -  -  -  -  -  *  -  -  -  -
 -  -  -  *  *  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -
 -  -  -  -  -  -  -  -  -  -

```
___

## Creation of a gif

The following class helps you to create an animated GIf, from multiple already created images of <br>
all generated boards:

>TestProjects/output/GIFOutput.php
>
> CLI-command: --output GifOutput

## Creation of a png image 

The following class helps you to create multiple images of all generated boards:

>TestProject/output/PNGOutput.php
> 
> CLI-command: --output PNGOutput
___
## Animated-gif of the board

Use following command to create an animated-gif of the board:
>--output GifOutput

![bg](src/imageOutput/gif-output.gif)
___
## Pluggable Rules

The following classes gives the user the opportunity to work with two additional Rules <br>
than only with the standard Rule, which is described at the beginning of the *README*. <br>

> TestProject/src/rules/StandardRule.php <br>
> TestProject/src/rules/CopyRule.php<br>
> TextProject/src/rules/Two45Rule.php <br>

Example to execute the desired Rule:

> --rule StandardRule<br>
> --rule CopyRule<br>
> --rule Two45Rule

Example to execute the desired Rule in combination with a pluggable-input <br>
pluggable-output and implemented commands which can be found in the gameoflife.php <br>
and down below:

````text
Usage: gameoflife.php [options] [operands]                             
Options:                                                               
  -i, --input <arg>        Which input should be used to fill the board
  -o, --output <arg>      Which output should be used                  
  -w, --width <arg>       Sets the width of the board                  
  -e, --height <arg>      Sets the height of the board                 
  -s, --maxSteps <arg>    Sets the number of the generations           
  -v, --version           Shows the version
  -h, --help              Shows a help/guide menu
  -r, --rule <arg>        Used to specify the rule to use
  -g, --gliderPosition <arg>  Set the start position of the glider on the coordinates x,y -> CLI-command: "-g 10,10" or "--gliderPosition 10,10"
  -f, --fillingLevel <arg>  Sets the filling number of living cells in percent -> CLI-command: "-f 100" or "--fillingLevel 100"
  -p, --gifCellSize <arg>  Set the size for each cell inside of a gif-output in pixel-format -> CLI-command: "-p 10" or "--gifCellSize 10"
  -c, --gifCellColor <arg>  Set the color for each cell inside a gif-output in rgb-format -> CLI-command: "-c 14,155,14" or "--gifCellColor 14,14,14"
````

> -r StandardRule -i Random -f 100 -s 50 -w 100 -e 100 -o GIFOutput -p 20 -c 0,0,0