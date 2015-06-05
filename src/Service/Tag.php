<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity;
use inklabs\kommerce\View;
use inklabs\kommerce\Lib;
use inklabs\kommerce\EntityRepository;

class Tag extends AbstractService
{
    /** @var Lib\PricingInterface */
    private $pricing;

    /** @var EntityRepository\TagInterface */
    private $tagRepository;

    public function __construct(EntityRepository\TagInterface $tagRepository, Lib\PricingInterface $pricing)
    {
        $this->pricing = $pricing;
        $this->tagRepository = $tagRepository;
    }

    public function create(Entity\Tag & $tag)
    {
        $this->throwValidationErrors($tag);
        $this->tagRepository->create($tag);
    }

    public function edit(Entity\Tag & $tag)
    {
        $this->throwValidationErrors($tag);
        $this->tagRepository->save($tag);
    }

    /**
     * @param int $id
     * @return View\Tag|null
     */
    public function find($id)
    {
        $entityTag = $this->tagRepository->find($id);

        if ($entityTag === null) {
            return null;
        }

        return $entityTag->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @param string $code
     * @return View\Tag|null
     */
    public function findOneByCode($code)
    {
        $entityTag = $this->tagRepository->findOneBy([
            'code' => $code
        ]);

        if ($entityTag === null) {
            return null;
        }

        return $entityTag->getView()
            ->withAllData($this->pricing)
            ->export();
    }

    /**
     * @param int $id
     * @return View\Tag|null
     */
    public function findSimple($id)
    {
        $entityTag = $this->tagRepository->find($id);

        if ($entityTag === null) {
            return null;
        }

        return $entityTag->getView()
            ->export();
    }

    /**
     * @param int $tagId
     * @return Entity\Tag
     * @throws \LogicException
     */
    public function getTagAndThrowExceptionIfMissing($tagId)
    {
        $tag = $this->tagRepository->find($tagId);

        if ($tag === null) {
            throw new \LogicException('Missing Tag');
        }

        return $tag;
    }

    public function getAllTags($queryString = null, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository->getAllTags($queryString, $pagination);
        return $this->getViewTags($tags);
    }

    public function getTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository->getTagsByIds($tagIds, $pagination);
        return $this->getViewTags($tags);
    }

    public function getAllTagsByIds($tagIds, Entity\Pagination & $pagination = null)
    {
        $tags = $this->tagRepository->getAllTagsByIds($tagIds, $pagination);
        return $this->getViewTags($tags);
    }

    /**
     * @param Entity\Tag[] $tags
     * @return View\Tag[]
     */
    private function getViewTags($tags)
    {
        $viewTags = [];
        foreach ($tags as $tag) {
            $viewTags[] = $tag->getView()
                ->export();
        }

        return $viewTags;
    }
}
