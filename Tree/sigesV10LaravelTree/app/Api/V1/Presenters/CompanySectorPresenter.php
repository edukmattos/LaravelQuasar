<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\CompanySectorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class CompanySectorPresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class CompanySectorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new CompanySectorTransformer();
    }
}
