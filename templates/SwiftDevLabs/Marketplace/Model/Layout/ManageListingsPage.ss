<h1>{$Title}</h1>

<div class="actions">
    <a href="{$PostListingLink}" class="post-an-item">Post an Item</a>
</div>

<% if $Listings %>
    <div class="my-listings listings">
        <% loop $Listings %>
            <% include ListingItem %>
        <% end_loop %>
    </div>
<% else %>
    <p>No listings found</p>
<% end_if %>