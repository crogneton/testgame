<!DOCTYPE html>
<html>
<head>
    <title>Игра</title>
    <style>
        body { padding: 0; margin: 0; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/phaser@3/dist/phaser.min.js"></script>
</head>
<body>
    
    <script>
	
	
var config = {
        type: Phaser.AUTO,
        width: 800,
        height: 600,
        physics: {
            default: 'arcade',
            arcade: {
                gravity: { y: 0 },
                debug: false
            }
        },
        scene: {
            preload: preload,
            create: create,
            update: update
        }
}

        var game = new Phaser.Game(config);


		
var player;
var cursors;
const numTiles = 20;
const tileSize = 40;
const halfTile = tileSize / 2;
let obstacles;




function preload () {
        this.load.image('grass', 'img/grass.png');
        this.load.image('player', 'img/player.png');
        this.load.image('stone', 'img/stone.png');
}





function create() {

    // Устанавливаем границы мира и камеры
    this.physics.world.bounds.width = numTiles * tileSize;
    this.physics.world.bounds.height = numTiles * tileSize;
    this.cameras.main.setBounds(0, 0, numTiles * tileSize, numTiles * tileSize);
    
    // Создаем тайлы по всему игровому полю
    for (let i = 0; i < numTiles; i++) {
        for (let j = 0; j < numTiles; j++) {
            this.add.image(i * tileSize, j * tileSize, 'grass').setOrigin(0);
        }
    }

    // Создаем персонажа игрока с учетом половины тайла
    player = this.physics.add.sprite(tileSize + halfTile, tileSize + halfTile, 'player').setOrigin(0, 0);
    
    // Физические свойства для игрока
    player.setCollideWorldBounds(true);
    
    // Создаем непроходимые объекты
    obstacles = this.physics.add.staticGroup();

    // Создаем препятствия
    createObstacles(this, 33);

    // Управление игроком 
    cursors = this.input.keyboard.createCursorKeys();

    // Добавляем коллизию между игроком и препятствиями
    this.physics.add.collider(player, obstacles);
    
    // Взаимодействие камеры с игроком
    this.cameras.main.startFollow(player);
}

        
        
        function update() {
            move(player, cursors);
        }
		
///////////////////////////

//камни
function createObstacles(game, obstacleCount) {
    for (let i = 0; i < obstacleCount; i++) {
        let randomX = Math.floor(Math.random() * numTiles) * tileSize;
        let randomY = Math.floor(Math.random() * numTiles) * tileSize;
        
        let obstacle = game.physics.add.sprite(randomX, randomY, 'stone').setOrigin(0);
        obstacle.body.setOffset(0, 0); // Установить начало координат тела в его верхний левый угол
        obstacle.setCollideWorldBounds(true);
        obstacle.setImmovable();
        
        obstacles.add(obstacle);
    }
}

	
function move(player, cursors) {
    const speed = 3.5; // Устанавливаем скорость движения
    const diagonalSpeed = speed * Math.SQRT1_2; // Уменьшаем скорость для диагонального движения

    // Проверяем, передвигается ли игрок по диагонали
    const isMovingDiagonally = (cursors.up.isDown || cursors.down.isDown) && (cursors.left.isDown || cursors.right.isDown);

    const currentSpeed = isMovingDiagonally ? diagonalSpeed : speed;

    if (cursors.left.isDown) {
        player.x -= currentSpeed;
    } else if (cursors.right.isDown) {
        player.x += currentSpeed;
    }
    if (cursors.up.isDown) {
        player.y -= currentSpeed;
    } else if (cursors.down.isDown) {
        player.y += currentSpeed;
    }
}


		
		
		
		
		
		
		
		
		
		
    </script>

</body>
</html>