chmod +x bin/console
if [ ! -f "./.db-created" ]; then
  bin/console doctrine:schema:create && touch ./.db-created
else
  bin/console doctrine:schema:update --force
fi
