# CodeQ.Blog.Utils

A package that provides useful tools, like NodeType Mixins and Fusion 
helpers to set up a blog in Neos CMS.

## NodeType Mixins

The NodeType Mixins of this package are meant to be used 
with your own NodeTypes to add certain blog functionality to them. 
To do so, you just use them as super types:

```yaml
'CodeQ.Blog:Document.BlogPost':
  superTypes:
    'CodeQ.Blog.Utils:Mixin.Post': true
```

Here is an overview over the existing NodeType Mixins and their use.

### CodeQ.Blog.Utils:Mixin.Blog
A mixin to be used for the root node of a blog.

### CodeQ.Blog.Utils:Mixin.BlogPost
This mixin adds post related properties to your NodeType,
like `createdAt`, `image` and certain constraints.

### CodeQ.Blog.Utils:Mixin.PostGroup
### CodeQ.Blog.Utils:Mixin.Tag
### CodeQ.Blog.Utils:Mixin.Taggable
A mixin to be added to a post to make it taggable.

## Fusion Helpers

### CodeQ.Blog.Utils:Helper.PostCollection
Returns an unfinished FlowQuery with blog posts. By default, it will query all nodes
extending the `BlogPost`-Mixin that are recursive children of your current documentNode.
For more specific use cases, the `for`-property can be defined. You can either pass a node extending
`BlogOverview`, `BlogPostGroup` or `BlogTag`.

Usage:
```neosfusion
postsQuery = CodeQ.Blog.Utils:Helper.PostCollection {
  # for: root node to query blog posts from, default is current documentNode
  for = ${myNode}
  # sort: accepts ASC or DESC, default is DESC
  sort = 'ASC'
}
# to actually get the posts, you need to call .get()
posts = ${this.postsQuery.get()}
```

### CodeQ.Blog.Utils:Helper.PostGroupCollection
### CodeQ.Blog.Utils:Helper.TagCollection
### CodeQ.Blog.Utils:Helper.PostThumbnailUri

Returns the uri to the thumbnail of a blog post, or the uri to the thumbnail placeholder.

Usage:
```neosfusion
thumbnailUri = CodeQ.Blog.Utils:Helper.PostThumbnailUri {
  # node: the blog post node
  node = ${node}
}
```
