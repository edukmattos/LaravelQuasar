<?php

namespace App\Presenters;

use App\Transformers\ClientSubSectorTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ClientSubSectorPresenter.
 *
 * @package namespace App\Presenters;
 */
class ClientSubSectorPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ClientSubSectorTransformer();
    }
}
