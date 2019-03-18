<?php
namespace Application\Service;

use Application\Controller\CatalogsController;
use Application\Entity\Cars;
use Doctrine\ORM\EntityManager;

// Сервис The CatalogManager, отвечающий за дополнение новых каталогов
class CatalogManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    // Конструктор, используемый для внедрения зависимостей в сервис.
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Этот метод добавляет новый пост.

    /**
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addNewCatalog($data)
    {
        // Создаем новую сущность catalog.
        $car = new Cars();
        $car->setModel($data['model']);
        $car->setDescription($data['description']);

        // Добавляем сущность в менеджер сущностей.
        $this->entityManager->persist($car);

        // Применяем изменения к базе данных.
        $this->entityManager->flush();
        
    }


    // Этот метод позволяет обновлять данные одного поста.

    /**
     * @param $catalog
     * @param $data
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function updateCatalog(Cars $catalog, $data)
    {
        $catalog->setModel($data['model']);
        $catalog->setDescription($data['description']);

        /*$mp = explode(",", $catalog->getPath());
        $mp[0] = $catalog->getParent();
        $editMp = join(',', $mp);
        $catalog->setPath($editMp);*/

       // var_dump($catalog->getParent().$data['parent_id']);

        // Применяем изменения к базе данных.
        $this->entityManager->flush();
    }

    // Удаляет пост и все связанные с ним комментарии.

    /**
     * @param $car
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function removeCatalog($car, $goodManager)
    {

        $this->entityManager->remove($car);

        $this->entityManager->flush();
    }

}