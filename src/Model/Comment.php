<?php

declare(strict_types=1);

namespace OnixSystemsPHP\HyperfSupport\Model;

use Carbon\Carbon;
use Hyperf\Database\Model\Relations\BelongsTo;
use Hyperf\Database\Model\Relations\MorphMany;
use Hyperf\Database\Model\SoftDeletes;
use OnixSystemsPHP\HyperfCore\Model\AbstractModel;
use OnixSystemsPHP\HyperfFileUpload\Model\Behaviour\FileRelations;
use OnixSystemsPHP\HyperfSupport\Service\Integration\Traits\FormatHelper;

/**
 * Comment
 *
 * @property int $id
 * @property int $ticket_id
 * @property string $content
 * @property string $creator_name
 * @property string|null $trello_comment_id
 * @property string|null $slack_comment_id
 * @property int|null $created_by
 * @property int|null $modified_by
 * @property int|null $deleted_by
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $modified_at
 * @property-read Ticket $ticket
 * @property-read MorphMany $files
 */
class Comment extends AbstractModel
{
    use FileRelations;
    use FormatHelper;
    use SoftDeletes;

    public $fileRelations = [
        'files' => [
            'limit' => null,
            'required' => false,
            'mimeTypes' => ['*'],
            'presets' => [],
        ],
    ];

    /**
     * The table associated with the model.
     */
    protected ?string $table = 'comments';

    /**
     * The attributes that are mass assignable.
     */
    protected array $fillable = [
        'ticket_id',
        'content',
        'creator_name',
        'trello_comment_id',
        'slack_comment_id',
        'created_by',
        'modified_by',
        'deleted_by',
        'files',
    ];

    /**
     * @return BelongsTo
     */
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * @param string $value
     * @return void
     */
    public function setContentAttribute(string $value): void
    {
        $this->attributes['content'] = $this->formatComment($value);
    }
}