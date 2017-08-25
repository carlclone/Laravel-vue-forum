基于Laravel5.4和VUE2，写一个论坛会牵涉到许多的功能，是一个很好的Digging Deeper项目。

## Feature：

- 使用模板模式重构搜索功能为Filters类，遵循开闭原则。
- 使用Laravel的消息通知系统实现@用户（带auto-completion）和订阅帖子提醒功能，并用事件系统解耦。
- 使用VUE组件化，部分逻辑和渲染迁移到前端。
- RecordActivity Trait记录用户活动时间线。
- 使用Policy做权限验证
