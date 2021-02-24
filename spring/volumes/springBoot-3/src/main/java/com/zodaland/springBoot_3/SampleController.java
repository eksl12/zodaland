package com.zodaland.springBoot_3;

import org.springframework.boot.*;
import org.springframework.boot.autoconfigure.*;
import org.springframework.stereotype.*;
import org.springframework.web.bind.annotation.*;
@Controller
@EnableAutoConfiguration
public class SampleController {
	@RequestMapping("/")
	@ResponseBody
	String home() {
		System.out.println("test");
		return "Hello World!";
	}
	@RequestMapping("/java")
	@ResponseBody
	String goJava() {
		return "Hello Java!";
	}
}
