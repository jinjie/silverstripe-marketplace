<div class="listing-item">
    <h2 class="listing-title"><a href="{$Link}">{$Title}</a></h2>
    <div class="listing-price">Price: {$Price.Nice}</div>
    <div class="listing-summary">{$Description.Summary}</div>
    <% if $IsMine %>
        <div class="listing-status">
            {$Status}
        </div>
    <% end_if %>
    <div class="listing-seller-meta">
        <span class="ago">Posted {$Created.Ago}</span> by
        <span class="seller">{$Seller.Name}</span>
    </div>

    <div class="listing-actions">
        <a href="{$EditLink}">Edit</a>
    </div>
</div>