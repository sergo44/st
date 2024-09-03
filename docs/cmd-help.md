# Справочник по командам
## Подключение к консоли mysql
```shell
docker exec -it soberitur-mariadb mysql -ust_use -pNKSyGuaO3a sps_db
```

# Развертывание проекта в продакшине
## Устанавливаем docker
```shell
lsb_release -a

# Add Docker's official GPG key:
apt-get update
apt-get install ca-certificates curl
install -m 0755 -d /etc/apt/keyrings
curl -fsSL https://download.docker.com/linux/debian/gpg -o /etc/apt/keyrings/docker.asc
chmod a+r /etc/apt/keyrings/docker.asc

# Add the repository to Apt sources:
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/debian \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  tee /etc/apt/sources.list.d/docker.list > /dev/null

apt-get update
apt-get upgrade -y && apt-get dist-upgrade
apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

## Развертываем проект
```shell
apt install git mc
mkdir -p /var/www/soberitur.ru
chown www-data:www-data /var/www/soberitur.ru
cd /var/www/soberitur.ru
sudo -u www-data git clone https://github.com/sergo44/st .
sudo -u www-data git switch feature/Sight # Temporary most actual branch
cd docker/
cp ./.env-example ./.env # replace passwords to secret and port to 80, 433
docker compose up -d
```