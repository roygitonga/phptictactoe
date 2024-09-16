# phptictactoe

## Tic Tac Toe - PHP Game with Sessions and HTML

### Tic Tac Toe Game

Welcome to the Tic Tac Toe game! This is a simple implementation of the classic game in PHP that allows a player to compete against a computer. The game features an interactive web interface with CSS styling and blinking effects for winning combinations.

### Features

- **Player vs. Computer**: Play against an AI opponent.
- **Winning Conditions**: Automatically detects and highlights winning combinations.
- **Blinking Effect**: Winning cells blink to highlight the winning move.
- **Pastel Colors**: Cells are colored in pastel blue for player moves and pastel red for computer moves.

### Getting Started

#### Prerequisites

- PHP 7.0 or higher
- A web server with PHP support (e.g., Apache, Nginx)

#### Installation

1. ** Clone the Repository**:

   ```bash
   git clone https://github.com/yourusername/tic-tac-toe.git
   cd tic-tac-toe


#### Set Up a Web Server:

Place the files in your web server's root directory (e.g., htdocs for XAMPP, www for WAMP).

Start the Web Server:

Ensure your web server is running. Access the game via http://localhost/tic-tac-toe.


#### Usage
Starting the Game:

Load the page in your web browser.
Click on any empty cell to make a move.
Winning the Game:

The game detects winning conditions and highlights the winning cells with a blinking effect.
A message will indicate whether the player or computer has won the round or if the game ended in a draw.
Starting a New Game:

Click the "Start New Game" button to reset the board and start a fresh game.


#### Code Overview

index.php
Initialization: Sets up the game state and board.
Game Logic: Handles player moves, computer moves, and win checks.
HTML/CSS/JS: Provides the game interface and interactivity.
**** Functions
initGame(): Initializes the game state.
printBoard($board): Prints the game board with styling.
checkWin($board, $player): Checks for winning conditions.
findBestMove(): Determines the computer's move.
playerMove($cell): Handles a player's move.
computerMove(): Handles the computer's move.

CSS
.cell: Basic styling for game cells.
.player1: Styling for player moves (pastel blue).
.player2: Styling for computer moves (pastel red).
.winner: Blinking effect for winning cells.


#### Contributing
Contributions are welcome! If you have suggestions, bug reports, or improvements, please open an issue or submit a pull request.


#### License
This project is licensed under the MIT License - see the LICENSE file for details.


#### Contact
For any questions or inquiries, feel free to reach out
