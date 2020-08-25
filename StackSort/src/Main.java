import java.util.Stack;


public class Main
{

	/**
	 * @param args
	 */
	public static void main(String[] args)
	{
		Stack A = new Stack();
		A.push(new Integer(3));
		A.push(new Integer(2));
		A.push(new Integer(5));
		A.push(new Integer(4));
		A.push(new Integer(1));
		A.push(new Integer(10));
		A.push(new Integer(9));
		A.push(new Integer(100));
		A.push(new Integer(1));
		A.push(new Integer(2));
		A.push(new Integer(7));
		A.push(new Integer(8));
		A.push(new Integer(1000));
		
		A = ascendingorder(A);
		
		while(!A.isEmpty()) {
			System.out.println(A.pop());
		}
	}
	
	public static Stack ascendingorder(Stack A){
		Stack B = new Stack();
		
		while(!A.isEmpty()) {
			Integer value = (Integer) A.pop();
			
			if(B.isEmpty()) {
				B.push(value);
			}
			else {
				Integer Bvalue = (Integer) B.peek();
				if(value.intValue() >= Bvalue.intValue()) {
					B.push(value);
				}
				else {
					int count = 0;
					
					while(value.intValue() < Bvalue.intValue() && !B.isEmpty()) {
						A.push(B.pop());
						Bvalue = (Integer) (B.isEmpty() ? new Integer(-1) : B.peek());
						count++;
					}
					
					B.push(value);
					
					for(int i = 0; i < count; i++) {
						B.push(A.pop());
					}
				}
			}
		}
		
		
		return B;
		
	}

}
