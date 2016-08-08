# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  #启动的box名
  config.vm.box = "hdvg56"

  # 端口映射
  config.vm.network"forwarded_port",guest:80,host:8002
  config.vm.network"forwarded_port",guest:3306,host:33062
  config.vm.network"forwarded_port",guest:6379,host:63792
end
