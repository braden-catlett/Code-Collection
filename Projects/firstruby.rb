#hello.rb
class Cat
	def initialize(breed, name)
		@breed = breed
		@name = name
	end
	def getName
		puts @name
	end
	def meow
		puts 'MEWZ MEWZ'
	end
	def getAge
		puts (7 * Random.rand(15)).to_s + " in Human Years"
		c = 155
		puts c.chr
	end
end
class Integer
  N_BYTES = [42].pack('i').size
  N_BITS = N_BYTES * 8
  MAX = 2 ** (N_BITS - 2) - 1
  MIN = -MAX - 1
end
def fib(a, b)
	c = a + b
	a = b
	b = c
	puts c
	if( c < Integer::MAX)
		fib(a,b)
	end
end
cat = Cat.new('Short Hair','Sly C. Mewz')
cat.meow
cat.getName
cat.getAge
a = 0
b = 1
puts a
puts b
fib(a,b)
