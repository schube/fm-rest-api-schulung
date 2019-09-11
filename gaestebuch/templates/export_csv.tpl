{foreach item=record from=$records}
{$record->field('Absender')},{$record->field('Betreff')},{$record->field('Email')},{$record->field('DatumUndUhrzeit')}
{/foreach}