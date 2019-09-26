# WCS 平台设计

## 概述

WCS 平台需要考虑内部实时性及外部实时性，分别表现为：

  1. 平台发起 IO 与设备交互
  2. 外界发起 IO 与平台交互

根据以上两点，WCS 平台可分解为**调度系统(master)**和**业务系统(system)**。

master 管理着 IO 上下文，为 system 提供运行环境。
system 拥有相似的行为，能够解决不同的问题，并可以**复用**。

master 由 server 模块构成，每个模块独立运行，
比如：http server 为外界提供 http 服务。
server 需要满足以下要求：

  1. 自启动
  2. 关闭后自动重启

system 是业务核心，例如：提升机系统。
主要负责与外部设备之间的 IO，并将设备数据同步到系统中。

## 提升机系统

### run

1. 任务监控，间隔为 min
2. 状态读取，间隔为 1s
3. 心跳写入，间隔为 2s

### stop

结束调用

### Task Manager

任务管理器用于执行周期性的循环任务，包括心跳处理、数据采集等。
1. 任务时钟 t：从 0 开始，每次循环将自增 1，到 max 后重新回到 0，周而复始
2. 任务管理器将永远执行，循环间隔为 1s（暂时）

### heartbeat connector

将任务时钟 t 写入到 PLC 系统中，写入间隔为 3s

### data collector

将提升机数据（PLC）采集至 redis 数据库中

### command console

命令控制器，订阅一个 command 频道，按顺序处理 command 中的命令
