# lyon-news-syndication
A WordPress plugin for consuming REST API.

**Stored in the context of the Widget** 
- API query
- Date/time of last post matching criteria
- Last edit
- Last edit's user ID
- Categories*
- Total categories
- Tags*
- Total tags

**Stored in the transient**
- Full markup of currently served content

*Pull all from API and count them:
- If greater or less than than saved total, regenerate list. 
- If equal to compare to array with the IDs. 
- If the same, use what is saved. 
- If different, regenerate list.
