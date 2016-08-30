# lyon-news-syndication
A WordPress plugin for consuming REST API.

Stored in the context of the Widget 
- API query
- Last edit
- Last edit's user ID
- Categories*
- Total categories
- Tags*
- Total tags

Stored in the transient
- Date/time of last post matching criteria
- Full markup of currently served content

*Pull all and count. 
- If greater or less than than saved total, regenerate list. 
- If equal to compare to array with the IDs. 
- If the same, use what is saved. 
- If different, regenerate list.
