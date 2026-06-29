# Blog2Social API endpoint mapping

Base URL: `https://api.blog2social.com/rest/v1.0`

| HTTP | Endpoint | Swagger tag | SDK method | Parameters |
|---|---|---|---|---|
| POST | `/user/auth` | Authentication | `authentication()->authenticateUser()` | JSON body |
| POST | `/user/list` | Authentication | `authentication()->listUsers()` | JSON body |
| POST | `/user/delete` | Authentication | `authentication()->deleteUsers()` | JSON body |
| POST | `/network/list` | Network | `network()->listNetwork()` | JSON body |
| POST | `/network/add` | Network | `connection()->addNetwork()` | Query |
| POST | `/network/update` | Network | `connection()->updateNetwork()` | Query |
| POST | `/network/categories` | Network | `categories()->listCategories()` | Query |
| POST | `/user/auth/list` | User | `user()->listUserAuthentications()` | Query |
| POST | `/user/auth/delete` | User | `user()->deleteUserAuthentication()` | Query |
| POST | `/network/post/create` | Share | `share()->createPost()` | JSON body |
| POST | `/network/post/remove` | Share | `share()->removePosts()` | JSON body |
| POST | `/network/post/insights/total` | Insights | `insights()->total()` | Query auth + JSON body |
| POST | `/network/post/insights/graph` | Insights | `insights()->graph()` | Query auth/fields + JSON body |
| POST | `/network/post/insights/status/enable` | Insights | `insights()->enableStatus()` | Query auth + JSON body |
| POST | `/network/post/insights/status/disable` | Insights | `insights()->disableStatus()` | Query auth + JSON body |
| POST | `/network/post/create/` | Video | `video()->createPost()` | Query auth/network + JSON array body |
| POST | `/video/upload` | Video | `videoUpload()->uploadChunk()` | Multipart form data |
| POST | `/video/check` | Video | `videoStatus()->check()` | Query |
| POST | `/app/add` | User Apps | `userApps()->addApp()` | Query |
| POST | `/app/list` | User Apps | `userApps()->listApps()` | Query |
| POST | `/app/modify` | User Apps | `userApps()->modifyApp()` | Query |
| POST | `/app/delete` | User Apps | `userApps()->deleteApp()` | Query |

The trailing slash in `/network/post/create/` is retained because it is a separate path in the supplied Swagger file under the `Video` tag.
