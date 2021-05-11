# READING-PROGRESS API

### Requirements
- Docker

### Install

1. Download repository
```
git clone [repository]
```

2. Build

The first installation
```
make build
```

### Docker Utils

Enter into your container
```
make sh
```

Start you containers
```
make start
```

Restart your container
```
make restart
```

### How to run composer
1. make sh
2. composer install


### How to run tests
1. make sh
2. composer [ phpunit | behat | test ]


### How to run phpcs fixer
1. make sh
2. composer phpcbf
3. composer phpcs
+ make your fixes if you have errors or warnings
