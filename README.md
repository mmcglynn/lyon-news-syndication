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


## NOTES

The name of the transient is per configuration, and has to be named as such to avoid collisions.

### Data

**Stored in ??**

1. time stamp (if not available anywhere else)
2. category (multiples?)
3. total records
4. thumbnail size

**Stored in Transient**

1. HTML string

**Plugin**

1. Date of latest post

### Logic

**On page load**

1. Get date of latest post
    1. Date matches database
        1. Transient exists
            1. Display transient
        2. Transient does not exist
            1. Get new data
            2. Save to transient
            3. Display transient
    2. Date doesn’t match database
        1. Get new data
        2. Save to transient
        3. Display transient
