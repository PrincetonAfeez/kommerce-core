<?php
namespace inklabs\kommerce\Service;

use inklabs\kommerce\Entity\Pagination;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\EntityRepository\ImageRepositoryInterface;
use inklabs\kommerce\EntityRepository\OptionRepositoryInterface;
use inklabs\kommerce\EntityRepository\TagRepositoryInterface;
use inklabs\kommerce\EntityRepository\TextOptionRepositoryInterface;
use inklabs\kommerce\Exception\EntityNotFoundException;
use inklabs\kommerce\Lib\UuidInterface;

class TagService implements TagServiceInterface
{
    use EntityValidationTrait;

    /** @var TagRepositoryInterface */
    private $tagRepository;

    /** @var ImageRepositoryInterface */
    private $imageRepository;

    /** @var OptionRepositoryInterface */
    private $optionRepository;

    /** @var TextOptionRepositoryInterface */
    private $textOptionRepository;

    public function __construct(
        TagRepositoryInterface $tagRepository,
        ImageRepositoryInterface $imageRepository,
        OptionRepositoryInterface $optionRepository,
        TextOptionRepositoryInterface $textOptionRepository
    ) {
        $this->tagRepository = $tagRepository;
        $this->imageRepository = $imageRepository;
        $this->optionRepository = $optionRepository;
        $this->textOptionRepository = $textOptionRepository;
    }

    public function update(Tag & $tag)
    {
        $this->tagRepository->update($tag);
    }

    /**
     * @param UuidInterface $tagId
     * @param UuidInterface $imageId
     * @throws EntityNotFoundException
     */
    public function removeImage(UuidInterface $tagId, UuidInterface $imageId)
    {
        $tag = $this->tagRepository->findOneById($tagId);
        $image = $this->imageRepository->findOneById($imageId);

        $tag->removeImage($image);

        $this->tagRepository->update($tag);

        if ($image->getProduct() === null) {
            $this->imageRepository->delete($image);
        }
    }

    /**
     * @param UuidInterface $tagId
     * @param UuidInterface $optionId
     * @throws EntityNotFoundException
     */
    public function removeOption(UuidInterface $tagId, UuidInterface $optionId)
    {
        $option = $this->optionRepository->findOneById($optionId);
        $tag = $this->tagRepository->findOneById($tagId);

        $tag->removeOption($option);

        $this->tagRepository->update($tag);
    }

    public function findOneById(UuidInterface $id)
    {
        return $this->tagRepository->findOneById($id);
    }

    public function findOneByCode($code)
    {
        return $this->tagRepository->findOneByCode($code);
    }

    public function getAllTagsByIds($tagIds, Pagination & $pagination = null)
    {
        return $this->tagRepository->getAllTagsByIds($tagIds, $pagination);
    }
}
