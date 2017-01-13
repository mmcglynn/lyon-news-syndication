# lyon-news-syndication
A WordPress plugin for consuming REST API.

## Data Storage

## Stored in the context of the instance (CPT?)
1. API constants
2. Last Edit (if not available anywhere else)
3. Last edit's user ID (if not available anywhere else)
4. Date/time of latest post matching criteria
5. category (multiples?)
6. total records
7. thumbnail size

## Optional
- Categories\*
- Total categories
- Tags\*
- Total tags

\*Pull all from API and count them:
- If greater or less than than saved total, regenerate list. 
- If equal to compare to array with the IDs. 
- If the same, use what is saved. 
- If different, regenerate list.

## Stored in Transient
1. HTML string
 1. Full markup of currently served content
 2. NOTE: The name of the transient is per configuration, and has to be named as such to avoid collisions.

## Logic

### On page load

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
