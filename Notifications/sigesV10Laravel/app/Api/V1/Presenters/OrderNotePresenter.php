<?php

namespace App\Api\V1\Presenters;

use App\Api\V1\Transformers\OrderNoteTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrderNotePresenter.
 *
 * @package namespace App\Api\V1\Presenters;
 */
class OrderNotePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderNoteTransformer();
    }
}
