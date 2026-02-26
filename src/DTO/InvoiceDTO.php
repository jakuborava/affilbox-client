<?php

namespace JakubOrava\AffilboxClient\DTO;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class InvoiceDTO
{
    use ArrayHelpers;

    /**
     * @param  Collection<int, InvoiceItemDTO>  $items
     */
    public function __construct(
        public readonly string $id,
        public readonly Carbon $created,
        public readonly Carbon $issueDate,
        public readonly Carbon $dueDate,
        public readonly ?Carbon $uploadDate,
        public readonly SupplierDTO $supplier,
        public readonly CustomerDTO $customer,
        public readonly string $vs,
        public readonly ?string $file,
        public readonly bool $paid,
        public readonly Collection $items,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $items = self::getArray($data, 'items');

        // API returns items as array of objects, or a single object
        $itemsCollection = isset($items[0]) && is_array($items[0])
            ? collect($items)->map(fn (array $item) => InvoiceItemDTO::fromArray($item))
            : collect([InvoiceItemDTO::fromArray($items)]);

        return new self(
            id: self::getString($data, 'id'),
            created: self::getCarbon($data, 'created'),
            issueDate: self::getCarbon($data, 'issueDate'),
            dueDate: self::getCarbon($data, 'dueDate'),
            uploadDate: self::getCarbonOrNull($data, 'uploadDate'),
            supplier: SupplierDTO::fromArray(self::getArray($data, 'supplier')),
            customer: CustomerDTO::fromArray(self::getArray($data, 'customer')),
            vs: self::getString($data, 'vs'),
            file: self::getStringOrNull($data, 'file'),
            paid: self::getBool($data, 'paid'),
            items: $itemsCollection,
        );
    }
}
