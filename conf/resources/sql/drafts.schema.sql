/**
 * drafts.schema.sql
 *
 * @author jason favrod <jason@epoquecorportation.com>
 * Created: Jul 8, 2017
 */

create table drafts (
    id int, -- primary key
    title text,
    published int, -- 0 not published 1 published.
    mod_timestamp text, -- iso 8601 e.g. 2017-07-08T13:27:34+00:00
    mod_epoque int, -- epoch time
    pub_timestamp text,
    pub_epoque int,
    content text
);
